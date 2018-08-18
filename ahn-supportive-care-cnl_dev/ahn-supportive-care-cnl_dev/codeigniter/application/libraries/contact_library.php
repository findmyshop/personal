<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contact_library
{
	public function __construct()
	{
		$this->CI =& get_instance();

		log_debug(__FILE__, __LINE__, __METHOD__, 'Initialized');
	}

	public function send_bug_report($args) {
		log_debug(__FILE__, __LINE__, __METHOD__, 'Called');

		$this->CI->postmark->initialize(array('mailtype' => 'html', 'proto'	=> 'mail'));

		$date = date('m-d-Y G:i:s');
		/* the output */
		$message = '<p>Hello, A bug report has been filed by a MedRespond user.</p>';
		$message .= '<table>';
		$message .= '<tr><td>User ID:</td>';
		$message .= '<td>'.$args['user_id'].'</td></tr>';
		$message .= '<tr><td>User Name:</td>';
		$message .= '<td>'.$args['username'].'</td></tr>';
		$message .= '<tr><td>Email:</td>';
		$message .= '<td>'.$args['email'].'</td></tr>';
		$message .= '<tr><td>Message:</td>';
		$message .= '<td>'.$args['report'].'</td></tr>';
		$message .= '<tr><td>Browser:</td>';
		$message .= '<td>'.$args['browser'].'</td></tr>';
		$message .= '<tr><td>Current Response:</td>';
		$message .= '<td>'.$args['current_response'].'</td></tr>';
		$message .= '<tr><td>Contact:</td>';
		$message .= '<td>'.$args['privacy'].'</td></tr>';
		$message .= '<tr><td>Video Ping:</td>';
		$message .= '<td>'.$args['video_ping'].'ms</td></tr>';
		$message .= '<tr><td>Last Message:</td>';
		$message .= '<td>'.$args['last_message'].'</td></tr>';
		$message .= '</table>';

		$this->CI->postmark->from('support@medrespond.com');
		$this->CI->postmark->to('support@medrespond.com');
		$this->CI->postmark->subject('Medrespond - Bug Report');
		$this->CI->postmark->message($message);
		$this->CI->postmark->send();
		$this->CI->postmark->clear();

		return TRUE;
	}

	public function send_question_feedback($args) {
		log_debug(__FILE__, __LINE__, __METHOD__, 'Called');

		$this->CI->postmark->initialize(array('mailtype' => 'html', 'proto'	=> 'mail'));

		$date = date('m-d-Y G:i:s');
		/* the output */
		$message = '<p>Hello, a question has been asked by a user.</p>';
		$message .= '<table>';
		$message .= '<tr><td>Email:</td>';
		$message .= '<td>'.$args['email'].'</td></tr>';
		$message .= '<tr><td>Question:</td>';
		$message .= '<td>'.$args['question'].'</td></tr>';
		$message .= '</table>';

		$this->CI->postmark->from('support@medrespond.com');
		$this->CI->postmark->to('support@medrespond.com');
		$this->CI->postmark->subject('Medrespond - Question Feedback');
		$this->CI->postmark->message($message);
		$this->CI->postmark->send();
		$this->CI->postmark->clear();

		return TRUE;
	}

	public function send_feedback()
	{
		log_debug(__FILE__, __LINE__, __METHOD__, 'Called');
	}

	/* Note: This is ONLY currently being used in SCC for mcortazz@wpahs.org */
	public function request_consult($user_id, $username, $pv, $browser, $current_response) {
		log_debug(__FILE__, __LINE__, __METHOD__, 'Called');

		$this->CI->postmark->initialize(array('mailtype' => 'html', 'proto' => 'mail'));
		$date = date('m-d-Y G:i:s');
		$message = "<p>Hello,</p><p>A consultation has been filed by a MedRespond user:</p><p>User ID: $user_id<br/>Username: $username<br/>Browser: $browser<br/>Current response: $current_response<br/>Date: $date<br/>Patient: ".$pv['patient']."<br/>Location: ".$pv['location']."<br/>Address: ".$pv['address']."<br/>Topic: ".$pv['topic']."<br/>Name: ".$pv['name']."<br/>Relationship: ".$pv['relationship']."<br/>Phone: ".$pv['phone']."<br/>Email: ".$pv['email']."<br/>Okay to Contact: ".$pv['privacy']."</p><p>Thank you,<br/>The MedRespond Team</p>";

		$this->CI->postmark->from('support@medrespond.com');
		if(ENVIRONMENT === 'production') {
			$this->CI->postmark->to('mcortazz@wpahs.org');
		} else {
			$this->CI->postmark->to('support@medrespond.com');
		}
		$this->CI->postmark->subject('Medrespond - Consultation');
		$this->CI->postmark->message($message);
		$this->CI->postmark->send();
		$this->CI->postmark->clear();

		return TRUE;
	}
}
