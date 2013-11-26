<tr>
	<?php if($_SESSION["lang"] == 'EN'){
		$footer_text = 'Copyright &copy; '.date("Y").' Berlitz AlAhsa, a Dar  Al-Khibra Human Resources Development Company. All Rights Reserved.';
		$footer_text .='<br/><center><b>Version 2.1.5</b></center>';
	}else{
		$footer_text = 'حق النشر &copy; '.date("Y").' بيرلتز الأحساء، ودار Khibra تنمية الموارد البشرية الشركة. جميع الحقوق محفوظة.';
	}
	?>
    <td align="center" valign="middle" class="footer"><?php echo $footer_text;?></td>
</tr>