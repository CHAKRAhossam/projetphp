<?php

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

require 'vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

// Include connection file
include('connection.php');

// Include the ArticleDevi file
include('articleDevi.php');

// Create an instance of class Connection
$connection = new Connection();

// Call the selectDatabase method
$connection->selectDatabase('projet');

// Include the Devi file
include('devi.php');

// Use the ArticleDevi class
$id = $_GET['id'];
$ArticleDevis = ArticleDevi::selectArticleDevisByDeviId('articledevis', $connection->conn, $id);

// Select the Devi by ID
$devi = Devi::selectDeviById($connection->conn, $id);

$devi_id = $devi['devi_id'];
$client_id = $devi['client_id'];
$client_firstname = $devi['client_firstname'];
$client_lastname = $devi['client_lastname'];
$client_email = $devi['client_email'];
$total = $devi['total'];

// Step 2: Load HTML into Dompdf
$options = new Options();
$options->set('isHtml5ParserEnabled', true);
$options->set('isPhpEnabled', true);

$dompdf = new Dompdf($options);

// HTML content starts here
$html = '
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>A simple, clean, and responsive HTML invoice template</title>
		<style>
			.invoice-box {
				max-width: 800px;
				margin: auto;
				padding: 30px;
				border: 1px solid #eee;
				box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
				font-size: 16px;
				line-height: 24px;
				font-family: \'Helvetica Neue\', \'Helvetica\', Helvetica, Arial, sans-serif;
				color: #555;
			}
			.invoice-box table {
				width: 100%;
				line-height: inherit;
				text-align: left;
			}
			.invoice-box table td {
				padding: 5px;
				vertical-align: top;
			}
			.invoice-box table tr td:nth-child(2) {
				text-align: right;
			}
			.invoice-box table tr.top table td {
				padding-bottom: 20px;
			}
			.invoice-box table tr.top table td.title {
				font-size: 45px;
				line-height: 45px;
				color: #333;
			}
			.invoice-box table tr.information table td {
				padding-bottom: 40px;
			}
			.invoice-box table tr.heading td {
				background: #eee;
				border-bottom: 1px solid #ddd;
				font-weight: bold;
			}
			.invoice-box table tr.details td {
				padding-bottom: 20px;
			}
			.invoice-box table tr.item td {
				border-bottom: 1px solid #eee;
			}
			.invoice-box table tr.item.last td {
				border-bottom: none;
			}
			.invoice-box table tr.total td:nth-child(2) {
				border-top: 2px solid #eee;
				font-weight: bold;
			}
			@media only screen and (max-width: 600px) {
				.invoice-box table tr.top table td {
					width: 100%;
					display: block;
					text-align: center;
				}
				.invoice-box table tr.information table td {
					width: 100%;
					display: block;
					text-align: center;
				}
			}
			/** RTL **/
			.invoice-box.rtl {
				direction: rtl;
				font-family: Tahoma, \'Helvetica Neue\', \'Helvetica\', Helvetica, Arial, sans-serif;
			}
			.invoice-box.rtl table {
				text-align: right;
			}
			.invoice-box.rtl table tr td:nth-child(2) {
				text-align: left;
			}
			.table-container {
				display: flex;
				justify-content: center;
				align-items: center;
				height: 100vh; /* Adjust the height if needed */
			}
			.table-margin {
				margin: 20px; /* Adjust the margin value according to your needs */
			}
		</style>
	</head>
	<body style="font-family: \'Segoe UI\', Tahoma, Geneva, Verdana, sans-serif">
		<div class="invoice-box ">
			<table cellpadding="0" cellspacing="0">
				<tr class="top">
					<td colspan="2">
						<table>
							<tr>
								<td>
									<div style="font-size: 30px; font-weight: bold; margin-bottom: 10px;">devi</div>
									<div style="font-size: 20px; color: gray;">' . $devi_id . '</div>
								</td>
							</tr>
						</table>
						<hr>
					</td>
				</tr>
				<tr class="information">
					<td colspan="2">
						<div class="table-container">
							<table class="table table-margin">
								<tr>
									<td>
										<div style="font-size: 30px; font-weight: bold; margin-bottom: 10px;">' . $client_firstname . ' ' . $client_lastname . '</div>
										<div style="font-size: 20px; color: gray; margin-bottom: 10px;">' . $client_id . '</div>
										<div style="font-size: 20px; color: gray;">' . $client_email . '</div>
									</td>
								</tr>
							</table>
						</div>
					</td>
				</tr>
				<table class="center">
					<thead class="heading" style="background-color: #D6EEEE;">
						<th>Article</th>
						<th>Qty</th>
						<th>Prix</th>
						<th>Prix * Qty</th>
					</thead>
					<tbody>';

// Fetching and displaying the article data
$ArticleDevis = ArticleDevi::selectArticleDevisByDeviId('articledevis', $connection->conn, $id);
if ($ArticleDevis !== null) {
    foreach ($ArticleDevis as $row) {
        $html .= "<tr>
                    <td>{$row['article_id']}</td>
                    <td>{$row['quantity']}</td>
                    <td>{$row['quantity']}</td>
                    <td>{$row['price']}</td>
                </tr>";
    }
} else {
    $html .= "<tr><td colspan='4'>No article found.</td></tr>";
}

$html .= '</tbody>
				</table>
			</table>';
$html .= "
			<h2 style='margin-left: 500px; color: #FF333F;' > Total: $total </h2>
			<div style='font-size: 20px;'>Thank you!</div>
		</div>
	</body>
</html>";

$dompdf->loadHtml($html);

// Step 3: Optional - Configure Dompdf
$dompdf->setPaper('A4', 'portrait'); // Set paper size and orientation

// Step 4: Render PDF
$dompdf->render();

// Step 5: Output or Save PDF
$dompdf->stream('document.pdf');
?>
