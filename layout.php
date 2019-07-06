<?php

class Layout
{
	private $width;
	private $height;
	private $lStyle_1;
	private $lStyle_2;
	private $lStyle_3;

	public function __construct($width, $height)
	{
		$this->width = $width;
		$this->height = $height;
	}

	public function PrintLine($char)
	{
		for ($i = 0; $i <= $this->width; $i++)
		{
			print($char);
		}
	}

	public function CenterString($str)
	{
		$len = strlen($str);
		$start = round(($this->width/2)-($len/2));


		for ($i = 0; $i <= $start; $i++)
		{
			print(" ");
		}
		print($str);
	}

}


$page = new Layout(80, 45);
$page->PrintLine("-");
print("\n");
$page->CenterString(" BONJOUR ");
print("\n");
$page->PrintLine("*");


?>
