<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once dirname(__FILE__) . '/third_party/tcpdf/tcpdf.php';

class Pdf_library extends TCPDF
{
	private $TMP_DIRECTORY = 'tmp/';

	function __construct()
	{
		parent::__construct();

		log_debug(__FILE__, __LINE__, __METHOD__, 'Initialized');
	}

	public function print_answers($answers, $account_id)
	{
		log_debug(__FILE__, __LINE__, __METHOD__, 'Called');

		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Allegheny Health Network');
		$pdf->SetTitle('Your Answers');
		$pdf->SetSubject('Supportive Care Answer Review');
		$pdf->SetKeywords('MedRespond, Supportive Care, Allegheny Health Network');

		$pdf->setHeaderData('ahn_logo.png', '50', '', '', array(0,0,0), array(0,0,0));
		$pdf->setFooterData(array(0,0,0), array(0,0,0));
		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
		$pdf->SetMargins(PDF_MARGIN_LEFT, 35, PDF_MARGIN_RIGHT);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

		if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
			require_once(dirname(__FILE__).'/lang/eng.php');
			$pdf->setLanguageArray($l);
		}
		$pdf->setFontSubsetting(true);
		$pdf->SetFont('helvetica', '', 12, '', true);
		$pdf->AddPage();

		$heading_html = "<h2>Your Answers</h2><h4>Supportive Care Options Review</h4><br>";
		$pdf->writeHTML($heading_html, true, false, false, true, 'C');

		$intro_html = "<p>You have reviewed the options for treatment and care settings. This is a record of your answers to questions about what you value most. Your answers to these questions can help you decide what type of care is most appropriate given your beliefs, values, resources, and what care settings are available to you. You can use these answers to talk about treatment options with family and healthcare providers.</p><br>";
		$pdf->writeHTML($intro_html, true, false, false, true, 'L');

		$columns = array('Question', 'Your Answer');
		$this->writeTable($columns, $answers, $pdf);

		$filename = 'answers_'.$account_id.'_'.date("Y-m-d_H-i-s").'.pdf';
		$filepath = FCPATH.$this->TMP_DIRECTORY.$filename;
		$pdf->Output($filepath, 'F');

		return $filename;
	}

	public function writeTable($header, $data, $pdf)
	{
		log_debug(__FILE__, __LINE__, __METHOD__, 'Called');

		// Colors, line width and bold font
		$pdf->SetFillColor(120, 187, 147);
		$pdf->SetTextColor(0,0,0);
		$pdf->SetDrawColor(46,46,46);
		$pdf->SetLineWidth(0.3);
		$pdf->SetFont('', 'B');

		// Header
		$num_headers = count($header);
		for($i = 0; $i < $num_headers; ++$i)
		{
			$pdf->Cell(90, 7, $header[$i], 1, 0, 'C', 1);
		}
		$pdf->Ln();

		// Color and font restoration
		$pdf->SetFillColor(200, 200, 200);
		$pdf->SetTextColor(0,0,0);
		$pdf->SetFont('');

		// Data
		$fill = 0;
		foreach ($data as $question => $answer)
		{
			$max_height = 0;
			$startX = $pdf->GetX();
			$startY = $pdf->GetY();

			$height = $pdf->MultiCell(90, 6, $question, 0, 'L', $fill, 0);
			if ($height > $max_height) {$max_height = $height;}
			$height = $pdf->MultiCell(90, 6, $answer, 0, 'L', $fill, 0);
			if ($height > $max_height) {$max_height = $height;}
			$pdf->SetXY($startX, $startY);

			$pdf->MultiCell(90, $max_height * 6, '', 'LR', 'L', $fill, 0);
			$pdf->MultiCell(90, $max_height * 6, '', 'LR', 'L', $fill, 0);

			$pdf->Ln();
			$fill=!$fill;
		}

		// Bottom line
		$pdf->Cell(180, 0, '', 'T');
	}
}
