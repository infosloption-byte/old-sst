<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Excursion Booking</title>
  <style type="text/css">

  /* Take care of image borders and formatting */

  img {
    max-width: 600px;
    outline: none;
    text-decoration: none;
    -ms-interpolation-mode: bicubic;
  }

  a {
    border: 0;
    outline: none;
  }

  a img {
    border: none;
  }

  /* General styling */

  td, h1, h2, h3  {
    font-family: Helvetica, Arial, sans-serif;
    font-weight: 400;
  }

  td {
    font-size: 13px;
    line-height: 150%;
    text-align: left;
  }

  body {
    -webkit-font-smoothing:antialiased;
    -webkit-text-size-adjust:none;
    width: 100%;
    height: 100%;
    color: #37302d;
    background: #ffffff;
  }

  table {
    border-collapse: collapse !important;
  }


  h1, h2, h3 {
    padding: 0;
    margin: 0;
    color: #444444;
    font-weight: 400;
    line-height: 110%;
  }

  h1 {
    font-size: 35px;
  }

  h2 {
    font-size: 30px;
  }

  h3 {
    font-size: 24px;
  }

  h4 {
    font-size: 18px;
    font-weight: normal;
  }

  .important-font {
    color: #21BEB4;
    font-weight: bold;
  }

  .hide {
    display: none !important;
  }

  .force-full-width {
    width: 100% !important;
  }

  </style>

  <style type="text/css" media="screen">
      @media screen {
        @import url(http://fonts.googleapis.com/css?family=Open+Sans:400);

        /* Thanks Outlook 2013! */
        td, h1, h2, h3 {
          font-family: 'Open Sans', 'Helvetica Neue', Arial, sans-serif !important;
        }
      }
  </style>

  <style type="text/css" media="only screen and (max-width: 600px)">
    /* Mobile styles */
    @media only screen and (max-width: 600px) {

      table[class="w320"] {
        width: 320px !important;
      }

      table[class="w300"] {
        width: 300px !important;
      }

      table[class="w290"] {
        width: 290px !important;
      }

      td[class="w320"] {
        width: 320px !important;
      }

      td[class~="mobile-padding"] {
        padding-left: 14px !important;
        padding-right: 14px !important;
      }

      td[class*="mobile-padding-left"] {
        padding-left: 14px !important;
      }

      td[class*="mobile-padding-right"] {
        padding-right: 14px !important;
      }

      td[class*="mobile-block"] {
        display: block !important;
        width: 100% !important;
        text-align: left !important;
        padding-left: 0 !important;
        padding-right: 0 !important;
        padding-bottom: 15px !important;
      }

      td[class*="mobile-no-padding-bottom"] {
        padding-bottom: 0 !important;
      }

      td[class~="mobile-center"] {
        text-align: center !important;
      }

      table[class*="mobile-center-block"] {
        float: none !important;
        margin: 0 auto !important;
      }

      *[class*="mobile-hide"] {
        display: none !important;
        width: 0 !important;
        height: 0 !important;
        line-height: 0 !important;
        font-size: 0 !important;
      }

      td[class*="mobile-border"] {
        border: 0 !important;
      }
    }
  </style>
</head>
<body class="body" style="padding:0; margin:0; display:block; background:#ffffff; -webkit-text-size-adjust:none" bgcolor="#ffffff">
<table align="center" cellpadding="0" cellspacing="0" width="100%" height="100%">
  <tr>
    <td align="center" valign="top" bgcolor="#ffffff"  width="100%">

    <table cellspacing="0" cellpadding="0" width="100%">
      <tr>
        <td style="border-bottom:1px solid #e7e7e7;">
          <center>
            <table cellpadding="0" cellspacing="0" width="600" class="w320">
              <tr>
                <td align="left" class="mobile-padding" style="padding:20px">

                  <br class="mobile-hide" />

                  <h2>Excursion Booking!</h2><br>
                  Dear Sir/ Madam,<br><br>
                  Thank you for your valuable excursion booking with us,<br>
                  Please find the attached payment link below which will enable you to pay for your selected excursion..<br><br>
                  <a href="{{url('/')}}/excursion/payment?ref={{$inq->payment->actvtran->ref_no}}">{{url('/')}}/excursion/payment?ref={{$inq->payment->actvtran->ref_no}}</a><br>

                  <br>We hope you will enjoy your stay in Sri Lanka

                </td>
              </tr>
            </table>
          </center>
        </td>
      </tr>
      <tr>
        <td valign="top" style="background-color:#f8f8f8;border-bottom:1px solid #e7e7e7;">

          <center>
            <table border="0" cellpadding="0" cellspacing="0" width="600" class="w320" style="height:100%;">
              <tr>
                <td valign="top" class="mobile-padding" style="padding:20px;padding-bottom: 10px;">
                  <table cellspacing="0" cellpadding="0" width="100%">
                    <tr>
                      <td style="padding-right:20px;width: 25%;">
                        <b>Reference No</b>
                      </td>
                      <td>
                        <b>Amount</b>
                      </td>
                      <td style="width: 30%;">
                        <b>Tour Start</b>
                      </td>
                    </tr>
                    <tr>
                      <td style="padding-top:5px; padding-right:20px; border-top:1px solid #E7E7E7; vertical-align:middle; ">
                        #{{$inq->payment->actvtran->no}}
                      </td>
                      <td style="padding-top:5px; border-top:1px solid #E7E7E7;">
                        {{$inq->payment->currency}} {{$inq->payment->amount}} <br>
                      </td>
                      <td style="padding-top:5px; border-top:1px solid #E7E7E7;">
                        {{\Carbon\Carbon::parse($inq->start_date)->format('Y-m-d')}}<br>
                      </td>

                    </tr>
                  </table>
                  <table cellspacing="0" cellpadding="0" width="100%">
                    <tr>
                      <td style="padding-top:50px;">
                        <table cellpadding="0" cellspacing="0" width="100%">
                          <tr>
                            <td width="350" style="vertical-align:top;text-align: center;">
                              Thanking you again!
                            </td>
                          </tr>
                        </table>
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>
            </table>
          </center>
        </td>
      </tr>
      <tr>
        <td style="background-color:#1f1f1f;">
          <center>
            <table border="0" cellpadding="0" cellspacing="0" width="600" class="w320" style="height:100%;color:#ffffff" bgcolor="#1f1f1f" >
              <tr>
                <td align="right" valign="middle" class="mobile-padding" style="font-size:12px;padding:10px; background-color:#1f1f1f; color:#ffffff; text-align:center; ">
                   SLIATO | slaito@chamber.lk | +9411 5588800 | +9411 5588802 
                </td>
              </tr>
            </table>
          </center>
        </td>
      </tr>
    </table>

    </td>
  </tr>
</table>
</body>
</html>
