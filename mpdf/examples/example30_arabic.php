<?php
$html = '<table width="500" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td width="325" align="left" valign="middle"><span id="result_box" lang="ar" xml:lang="ar">كيف حالك؟</span></td>
    <td width="175">&nbsp;</td>
  </tr>
  <tr>
    <td align="left" valign="middle"><span id="result_box" lang="ar" xml:lang="ar">هذا هو العرض التوضيحي حيث يمكننا اختباره.</span></td>
    <td align="left" valign="middle"><span id="result_box" lang="ar" xml:lang="ar">هذا هو العرض التوضيحي حيث يمكننا اختباره.</span></td>
  </tr>
  <tr>
    <td colspan="2" align="center" valign="middle"><span id="result_box" lang="ar" xml:lang="ar">هذا هو العرض التوضيحي حيث يمكننا اختباره.</span></td>
  </tr>
  <tr>
    <td colspan="2" align="center" valign="middle">&nbsp;</td>
  </tr>
</table>';
//==============================================================
//==============================================================
//==============================================================
include("../mpdf.php");

$mpdf = new mPDF('utf-8', 'A4-L');
$mpdf->WriteHTML($html);
$mpdf->Output();

exit;

//==============================================================
//==============================================================
//==============================================================


?>