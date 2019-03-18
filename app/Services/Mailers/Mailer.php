<?php
namespace App\Services\Mailers;

use Mail;
use View;
use App\Services\LoggerFactory;
use App\Models\MailBox;

class Mailer
{
	/**
	 * Add an email to the queue to be sent
	 *
	 * @param  string $queue      Name of the queue to add the email on
	 * @param  string $email      Email address to send the email to
	 * @param  string $view       Laravel view to template the email
	 * @param  array  $data       Array of data members to pass to the laravel view
	 * @param  string $subject    Subject of the email
	 * @param  ?      $attachment [description]
	 * @return null
	 */
	public function emailTo($queue, $email, $view, $data, $subject, $attachment = null, $attachment_options = null)
	{
		$view_text=$view.'-plain-text';
		if(!View::exists($view_text))
		{
			$view_text=$view;
		} 
		try{
			$mailBox = MailBox::find($data['id']);
			Mail::send($view, ['body' => $data], function ($message) use ($subject, $email) {
                $message->subject($subject);
                $message->from(env('MAIL_DEFAULT_FROM'));
                $message->to($email);
                $message->replyTo(env('MAIL_DEFAULT_FROM'));
            });

            if ($mailBox) {
            	$mailBox->status = MailBox::STATUS_COMPLETED;
            	$mailBox->response = 'success';
            	$mailBox->save();
            }
		// \Mail::send(['text'=>$view_text,'html'=>$view], $data, function ($message) use ($email, $subject, $attachment, $attachment_options) {
		// 		$message->to($email)->subject($subject);
		// 		$message->from(env('MAIL_DEFAULT_FROM'));

		// 		if ($attachment != null) {
		// 			$message->attachData($attachment, "aimsbuildmart.jpg");
		// 		}
		// 	}
		// );
	  } catch (\Exception $e)
	  	{
			$errorMessage=array();
			$errorMessage['message']=$e->getMessage();

			if ($mailBox) {
				$mailBox->status = MailBox::STATUS_REJECTED;
				$mailBox->response = $e->getMessage();
				$mailBox->save();
			}
			$this->log = (new LoggerFactory)->setPath('logs/emails')->createLogger('email-sending-issue');
			$this->log->info('Issue in email sending:',$errorMessage);
	  	}
    }

	public function queueTo($queue, $email, $view, $data, $subject, $attachment = null, $attachment_options = null)
	{
		if (is_string($email)) {
			$email = trim($email);
		}

		if (is_array($email)) {
			$email = array_map(
				function ($e) {
					return trim($e);
				}, $email
			);
		}
		$view_text=$view.'-plain-text';
		if(!View::exists($view_text))
		{
			$view_text=$view;
		} 
		try{

		\Mail::queue(
			['text'=>$view_text,'html'=>$view], $data, function ($message) use ($email, $subject, $attachment, $attachment_options) {
				$message->to($email)->subject($subject);
				$message->from(env('MAIL_DEFAULT_FROM'));

				if ($attachment != null) {
					$message->attachData($attachment, "parking-coupon.jpg");
				}
			}
		);
	   }catch (\Exception $e)
	  {
		  $errorMessage=array();
		  $errorMessage['message']=$e->getMessage();
		  $this->log = (new LoggerFactory)->setPath('logs/email-sending-issues-logs')->createLogger('email-sending-issue');
		  $this->log->info('Issue in email sending:',$errorMessage);
	  }
	}
}
