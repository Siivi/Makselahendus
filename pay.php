<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Example payment usage - SEB - Pangalink-net</title>
    </head>
    <body>
<?php

// THIS IS AUTO GENERATED SCRIPT
// (c) 2011-2020 Kreata OÜ www.pangalink.net

// File encoding: UTF-8
// Check that your editor is set to use UTF-8 before using any non-ascii characters

// STEP 1. Setup private key
// =========================
session_start();
$total_price=$_SESSION['total_price'];
$private_key = openssl_pkey_get_private(
"-----BEGIN RSA PRIVATE KEY-----
MIIEowIBAAKCAQEApcMgRDIcD927b/B+hi6P2al6Qy5yDFay0FTdVedvxfS4tMfg
PAVU4K0E1vYq+Sypgf66eQ/3aswDyCQwi2IeA9cbvgce0BIHm+ikwB2DXUbQiBUB
6AB7HZvRdqiqKOFJ7S72Hi/p35lsyGcuV1yIdWcjNHP+bymhfl10V8pYgFeW1otq
eA83KyEPLOqsH+3ZCaU2Tcf8VG5nJLYpZzFkJSgHZxKyg1WoE0/bDDTd2Bo8z1t7
6fLAGkUO65k6XS5i36RrRFtWhEL2le70JGspauui7djlxsRjlJw3wYzjY33PdlKo
XZiaQYaArDFepJzBXCnU4Fk82Z9X9eVgjZQjqQIDAQABAoIBAQCRFS0bo0Q+etNA
kZ0cMorDdvvE61T1CbkucOjc9Fk3SQ+VY1AXGI+GqskOoJ1SRE4EsoBhz6C9P92b
glle1bzxnYfxlefZM76nLkNsxyggLwf7428ssacQbj4yfkOYzj7XMwBFwagQhgfZ
i73axunE4EXG9jNe9nAb2w4mfLtjcF2GKumIgO85sPoQ+Cgw8UpBXk+MXT4fkYwC
VQ/hLTm0tWH0DSWBPmSJ8SuIHDg1GzUvMGoWu5B33QvfRPX7NpfYjciLTctbbvzx
qRXhsltuzV0XjRV4cNpLSa9v1W3F9/OUG9c55+Cm7qeGt7NbdbnHjrO/B0rqQGSw
ray0Qg5RAoGBANWMHJvn8qLQrsZ7ycT559gwKBSjTGgKmBQ8COA2oKrBTWHKjMJ1
LHCm/jqjc1ZJszq7VJCzc0bxA3QwS29Ym4OPQxHunbdNPH1MLd7xU68YbAdjbQza
Nwso8BaasxQhU7rk04hefwg/fLDRGC22f1v3Dwvi7MRiEJc0mm/GRjkFAoGBAMa3
IFhJwWJw8qGDl4g/ZdA1khFQqqJyHxJxItkrFHL0tB/HU7fNaa0QuOksDmukuES4
zShr+GIKhaJxNwkHqx+xCm/Rph31JV1ej3hYYztIPlUv26mOZ4y8HOfDwXvW5fbT
r1Y9jv9Q0TJ8VLIK/WVDpeqnv3/xy/sIN21AOHFVAoGAXwdWw9pYEzQiUplLlKhR
D9d+PpDcs3/jZT3CBWTJ4rLaqKXmNbLG7+qgP5/093UcmQo7+5ift/YQv2euagJY
UhcylYxGCwgH3wpDb26c+tI3YKJSKOIClKjHDogRIOgjxouFxq2mghked+DUjaMk
0dwDihqVml65W1BBWXQ2U7ECgYBwJ5l02yPvqKn4qOnUt1uCeUnYxfuYtep9oSc3
BQ6El0I2kWzZ13DmggKrb/cvoAd0mg0I3G+S/jdQaK/UQ+S8fVLTq7MjQ2J0YVN+
a/yN0AeGUv2apEojb2StFppUiATBG9bhSNs1lOqNoQi4eGVuSxEQ8N6vmswzAf8u
hUmWBQKBgGL41FiI8RS6c6N46bgzpTpgKw6ARh6BvkY1/8a5YYtDuwLcZdpzHrNX
JSZD4z43A2octmFqygLO0s0ws+3DLK2QJZKX/uD+4gaMHwoQftKP1THfSKwsgCjR
o67kGXszukIKAOhFViXVFmhtZhmbDWCXCLjM+doxl/uBtVoncQwz
-----END RSA PRIVATE KEY-----");

// STEP 2. Define payment information
// ==================================

$fields = array(
        "VK_SERVICE"     => "1011",
        "VK_VERSION"     => "008",
        "VK_SND_ID"      => "uid100010",
        "VK_STAMP"       => "12345",
        "VK_AMOUNT"      => number_format($total_price,2),
        "VK_CURR"        => "EUR",
        "VK_ACC"         => "EE171010123456789017",
        "VK_NAME"        => "Kauplus",
        "VK_REF"         => "1234561",
        "VK_LANG"        => "EST",
        "VK_MSG"         => "Ostud kauplusest",
        "VK_RETURN"      => "http://localhost:8080/success.php",
        "VK_CANCEL"      => "http://localhost:8080/cancel.php",
        "VK_DATETIME"    => date(DATE_ISO8601),
        "VK_ENCODING"    => "utf-8",
);

// STEP 3. Generate data to be signed
// ==================================

// Data to be signed is in the form of XXXYYYYY where XXX is 3 char
// zero padded length of the value and YYY the value itself
// NB! SEB expects symbol count, not byte count with UTF-8,
// so use `mb_strlen` instead of `strlen` to detect the length of a string

$data = str_pad (mb_strlen($fields["VK_SERVICE"], "UTF-8"), 3, "0", STR_PAD_LEFT) . $fields["VK_SERVICE"] .    /* 1011 */
        str_pad (mb_strlen($fields["VK_VERSION"], "UTF-8"), 3, "0", STR_PAD_LEFT) . $fields["VK_VERSION"] .    /* 008 */
        str_pad (mb_strlen($fields["VK_SND_ID"], "UTF-8"),  3, "0", STR_PAD_LEFT) . $fields["VK_SND_ID"] .     /* uid100010 */
        str_pad (mb_strlen($fields["VK_STAMP"], "UTF-8"),   3, "0", STR_PAD_LEFT) . $fields["VK_STAMP"] .      /* 12345 */
        str_pad (mb_strlen($fields["VK_AMOUNT"], "UTF-8"),  3, "0", STR_PAD_LEFT) . $fields["VK_AMOUNT"] .     /* 150 */
        str_pad (mb_strlen($fields["VK_CURR"], "UTF-8"),    3, "0", STR_PAD_LEFT) . $fields["VK_CURR"] .       /* EUR */
        str_pad (mb_strlen($fields["VK_ACC"], "UTF-8"),     3, "0", STR_PAD_LEFT) . $fields["VK_ACC"] .        /* EE171010123456789017 */
        str_pad (mb_strlen($fields["VK_NAME"], "UTF-8"),    3, "0", STR_PAD_LEFT) . $fields["VK_NAME"] .       /* ÕIE MÄGER */
        str_pad (mb_strlen($fields["VK_REF"], "UTF-8"),     3, "0", STR_PAD_LEFT) . $fields["VK_REF"] .        /* 1234561 */
        str_pad (mb_strlen($fields["VK_MSG"], "UTF-8"),     3, "0", STR_PAD_LEFT) . $fields["VK_MSG"] .        /* Torso Tiger */
        str_pad (mb_strlen($fields["VK_RETURN"], "UTF-8"),  3, "0", STR_PAD_LEFT) . $fields["VK_RETURN"] .     /* http://localhost:8081/project/M3Fbc6pb9G8VUaxs?payment_action=success */
        str_pad (mb_strlen($fields["VK_CANCEL"], "UTF-8"),  3, "0", STR_PAD_LEFT) . $fields["VK_CANCEL"] .     /* http://localhost:8081/project/M3Fbc6pb9G8VUaxs?payment_action=cancel */
        str_pad (mb_strlen($fields["VK_DATETIME"], "UTF-8"), 3, "0", STR_PAD_LEFT) . $fields["VK_DATETIME"];    /* 2020-05-27T12:59:19+0300 */

/* $data = "0041011003008009uid10001000512345003150003EUR020EE171010123456789017009ÕIE MÄGER0071234561011Torso Tiger069http://localhost:8081/project/M3Fbc6pb9G8VUaxs?payment_action=success068http://localhost:8081/project/M3Fbc6pb9G8VUaxs?payment_action=cancel0242020-05-27T12:59:19+0300"; */

// STEP 4. Sign the data with RSA-SHA1 to generate MAC code
// ========================================================

openssl_sign ($data, $signature, $private_key, OPENSSL_ALGO_SHA1);

/* PnH6F8Mspz3PqT6zq2LYNZrBvZWnam947SlIN9SN/aQGfkc2e32JLKgPq+/23pf0ba/2oRBESgIPHf8+qB+q/lVN/DVV0RW2iplykCG9h+hA2vxTaRJYYDEXcgYTOTRMvYLnaz6vUV+wzcHaY4F99w2aJ3sbBsshEGEQP5hdIjcjvCyJSWCqmAl75JFPpFar2PKrLPt8FRGHMDHK2fRqCXSWhX5M/XCNqRFToEZjXLEyfMaM8/JkSdPOcjZ+v4m421ixIKR7dEtD/eSfawOCZMXgpZ3/KsNCqpbuA/YWfAjsfZlgfXSrzJQj2IYszNYKHgRVJsUCFfPbFf9dx/SQIw== */
$fields["VK_MAC"] = base64_encode($signature);

// STEP 5. Generate POST form with payment data that will be sent to the bank
// ==========================================================================
?>

        <h1><a href="http://localhost:8081/">Pangalink-net</a></h1>
        <p>Makse teostamise näidisrakendus <strong>"SEBBank"</strong></p>

        <form method="post" action="http://localhost:8081/banklink/seb-common">
            <!-- include all values as hidden form fields -->
<?php foreach($fields as $key => $val):?>
            <input type="hidden" name="<?php echo $key; ?>" value="<?php echo htmlspecialchars($val); ?>" />
<?php endforeach; ?>

            <!-- draw table output for demo -->
            <table>
<?php foreach($fields as $key => $val):?>
                <tr>
                    <td><strong><code><?php echo $key; ?></code></strong></td>
                    <td><code><?php echo htmlspecialchars($val); ?></code></td>
                </tr>
<?php endforeach; ?>

                <!-- when the user clicks "Edasi panga lehele" form data is sent to the bank -->
                <tr><td colspan="2"><input type="submit" value="Edasi panga lehele" /></td></tr>
            </table>
        </form>

    </body>
</html>
