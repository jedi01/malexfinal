<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Payments_online
{
    private $ci;

	function __construct()
	{
    	$this->ci =& get_instance();
        // Load Encryption Library
        $this->ci->load->library('encryption');
	}

    public function PayPal_Express ($config)
    {
        // Setup payment gateway
        $gateway = Omnipay\Omnipay::create('PayPal_Express');
        $gateway->initialize(array(
            'username'  => $this->ci->encryption->decrypt($config->username),
            'password'  => $this->ci->encryption->decrypt($config->password),
            'signature' => $this->ci->encryption->decrypt($config->signature),
            'testMode'  => $config->sandbox == 1,
        ));
        return $gateway;
    }


    public function Skrill ($config)
    {
        // Setup payment gateway
        $gateway = Omnipay\Omnipay::create('Skrill');
        $gateway->setEmail($this->ci->encryption->decrypt($config->email));
        $gateway->setSecretWord($this->ci->encryption->decrypt($config->secretWord));
        $gateway->setTestMode($config->test_mode == 1);
        return $gateway;
    }

    public function Stripe ($config)
    {
		// Setup payment gateway
		$gateway = Omnipay\Omnipay::create('Stripe');
		$gateway->setApiKey($this->ci->encryption->decrypt($config->api_key));
        return $gateway;
    }

    public function TwoCheckout ($config)
    {
        // Setup payment gateway
        $gateway = Omnipay\Omnipay::create('TwoCheckout');
        $gateway->setAccountNumber($this->ci->encryption->decrypt($config->account_number));
        $gateway->setSecretWord($this->ci->encryption->decrypt($config->secretWord));
        $gateway->setTestMode($config->test_mode == 1);

        return $gateway;
    }

    public function MobilPay ($config)
    {
        // Setup payment gateway
        $gateway = Omnipay\Omnipay::create('MobilPay');

        $gateway->setMerchantId($this->ci->encryption->decrypt($config->merchant_id));
        $gateway->setPublicKey($this->ci->encryption->decrypt($config->public_key));
        $gateway->setTestMode($config->test_mode == 1);

        return $gateway;
    }

    public function make_payment ($payment = FALSE, $config = FALSE, $check = FALSE, $delete_on_error = TRUE)
    {
    	if( $payment == FALSE || $config == FALSE ){
            if( $check ){
                $result = array("status"=>"error", "message"=>lang("access_denied"));
                $this->ci->output->set_content_type('application/json')->set_output(json_encode($result));
                return false;
            }else{
	            $this->ci->session->set_flashdata('message', lang("access_denied"));
	            redirect('/payments', 'refresh');
	            return false;
	        }
    	}
		require("Composer/autoload.php");

		try {
			if( $payment->method == 'paypal' ){
				$gateway = $this->PayPal_Express($config->paypal);
			}elseif( $payment->method == 'stripe' ){
				$gateway = $this->Stripe($config->stripe);
			}elseif( $payment->method == 'twocheckout' ){
                $gateway = $this->TwoCheckout($config->twocheckout);
            }elseif( $payment->method == 'mobilpay' ){
                $gateway = $this->MobilPay($config->mobilpay);
            }elseif( $payment->method == 'skrill' ){
                $gateway = $this->Skrill($config->skrill);
            }else{
	    		return false;
			}

			$purchase = array(
	            'returnUrl'            => site_url('/payments/validate_payment?p_token='.$payment->token),
	            'cancelUrl'            => site_url('/payments/cancel_payment?p_token='.$payment->token),
	            'currency'             => CURRENCY_PREFIX,
			    'transactionId'        => $payment->number,
                'description'          => 'Payment N#'.sprintf("%06s", $payment->number),
	            'amount'               => $payment->amount,
	        );

            if( $payment->method == 'mobilpay' ){
                $purchase['order_id']  = $payment->number;
                $purchase['details']   = 'Payment N#'.sprintf("%06s", $payment->number);
                $purchase['confirmUrl'] = site_url('/payments/cancel_payment?p_token='.$payment->token);
            }

	        if( isset($payment->credit_card) ){
	        	$purchase['card'] = objectToArray($payment->credit_card);
	        }

			$transaction = $gateway->purchase($purchase);
	        $response = $transaction->send();
		    if ($response->isSuccessful() || $response->isRedirect()) {
		    	if( !$check && $payment->method != 'stripe' ){
		    		$response->redirect();
		    	}
		    	return true;
		    }else{
                if( $delete_on_error ){
                    $this->ci->payments_model->delete($payment->id);
                }
                $result = array("status"=>"error", "message"=>$response->getMessage());
                $this->ci->output->set_content_type('application/json')->set_output(json_encode($result));
                return false;
		    }
		} catch (\Exception $e) {
            if( $delete_on_error ){
                $this->ci->payments_model->delete($payment->id);
            }
            $result = array("status"=>"error", "message"=>$e->getMessage());
            $this->ci->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
		}
    }
}
