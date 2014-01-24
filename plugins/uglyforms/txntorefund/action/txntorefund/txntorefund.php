<?php
/**
* @copyright	Copyright (C) 2009 - 2009 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @package		Uglyforms
* @subpackage	Frontend
*/
if(defined('_JEXEC')===false) die();

/**
 * @author bhavya
 *
 */
class UglyformsActionTxntorefund extends UglyformsAction
{
	protected $_location	= __FILE__;
	public    $show_editor  = true;
	
	public function process($data, $attachments)
	{
		if(!class_exists('PayplansApi')){
			return true;
		}
		
		$params = $this->getActionParams();
		
		$emails = explode(',', $params->get('email'));
		
		$mailer  =  UglyformsFactory::getMailer();
		$mailer->addRecipient($emails);
			
		$body 	  = $this->getData();
		$body     = UglyformsHelperRewriter::rewrite($body, $data);
		
		$subject  = UglyformsHelperRewriter::rewrite($params->get('subject'), $data);				
		
		$username_field 		= $params->get('username_field');
		$email_field 			= $params->get('email_field');
		$subscriptionkey_field	= $params->get('subscriptionkey_field');
		$plan_field 			= $params->get('plan_field');
		
		$subId 		  = XiHelperUtils::getIdFromKey($data[trim($subscriptionkey_field)]);
		$subscription = PayplansApi::getSubscription($subId);
		
		$buyer = '';
		$title = '';
		$order = false;
		$invoice = false;

		//if subscription is not active then do not proceed further calculation
		if ($subscription !== false && $subscription->getStatus() == PayplansStatus::SUBSCRIPTION_ACTIVE){
			$buyer = $subscription->getBuyerUsername();
			$title = $subscription->getTitle();
			$order = $subscription->getOrder(true);
			//only master invoice has the data about all the transactions
			$invoice = $order->getLastMasterInvoice(true);
		}
		
		
		if(strcasecmp($buyer, $data[trim($username_field)]) !== 0){
			//username does not match with the subscription buyer
			$body .= Rb_Text::_('COM_UGLYFORMS_ACTION_TXNTOREFUND_USERNAME_DOES_NOT_MATCH');
			
		}
		
		if(strcasecmp(trim($title), trim($data[trim($plan_field)])) !== 0){
			//plan name of the subscription does not match with the provided plan 
			$body .= Rb_Text::_('COM_UGLYFORMS_ACTION_TXNTOREFUND_PLANNAME_DOES_NOT_MATCH');
		}
		
		$txnRecords = array();
		//check the invoice existance before calling functions on the object
		if ($invoice !== false){
			//if last-master invoice is not in paid status
			if($invoice->getStatus() != PayplansStatus::INVOICE_PAID){
				$paidInvoices = $order->getInvoices(PayplansStatus::INVOICE_PAID);
				ksort($paidInvoices);
				$invoice = array_shift($paidInvoices);
			}
			
			if ($invoice !== false){
				$transactions = $invoice->getTransactions();
		
				foreach ($transactions as $transaction){
					//consider only those transactions which contains some amount
					if ($transaction->getAmount() > 0){
						$txnId = $transaction->getId();
						$txnRecords[$txnId]['gateway_txn_id'] = $transaction->getGatewayTxnId();
						$txnRecords[$txnId]['txn_id'] = $txnId;
						$payment = $transaction->getPayment(true);
						$paymentApp = $payment->getApp(true);
						$txnRecords[$txnId]['gateway_type'] = $paymentApp->getType();
					}
				}
			}
		}
		
		if(empty($txnRecords)){
			$body .= Rb_Text::_('COM_UGLYFORMS_ACTION_TXNTOREFUND_NO_TRANSACTION_AVAILABLE');
		}
		else {
			ksort($txnRecords);
			
			$lastTransaction = array_pop($txnRecords);
			$siteTxnLink = JURI::root().'administrator/index.php?option=com_payplans&view=transaction&task=edit&id='.$lastTransaction['txn_id'];
			
			if($lastTransaction['gateway_type'] == 'paypal'){
				//IMP : paypal transaction url have country-code included, which we have ignored in this action
				//ask country code in action params for its consideration
				$paypalurl = ($params->get('test_mode')) ? "https://www.sandbox.paypal.com/cgi-bin/webscr?cmd=_view-a-trans&id=" : "https://www.paypal.com/cgi-bin/webscr?cmd=_view-a-trans&id=";
				$body .= Rb_Text::sprintf('COM_UGLYFORMS_ACTION_TXNTOREFUND_PAYPAL_TRANSACTION_LINK', $siteTxnLink, $paypalurl.$lastTransaction['gateway_txn_id']);
			}
				
			else {
				$body .= Rb_Text::sprintf('COM_UGLYFORMS_ACTION_TXNTOREFUND_OTHER_TRANSACTION_LINK',$siteTxnLink, $lastTransaction['gateway_type'],$lastTransaction['gateway_txn_id']); 
			}
		}
		
		$mailer->setSubject($subject);
		$mailer->setBody($body);
		
		if(!empty($data[trim($email_field)])){
			$mailer->addReplyTo($data[trim($email_field)], $data[trim($username_field)]);
		}
	
		$mailer->IsHTML(1);
		if ($mailer->Send() === true){
			return true;
		}
		
		return false;
	}

}
