<?php

function printLine($char, $num)
{
	for ($i = 0; $i <= $num; $i++)
	{
		print($char);
	}
}




class Request
{
	private $date;
	private $name;
	private $merchant;
	private $amount;
	private $reason;
	private $valid;
	private $canceled; 

	public function __construct()
	{
		$this->date = date("Y-m-d");
		$this->valid = false;
		$this->canceled = false;
	}

	public function Date($date = "")
	{
		if ($date == "")
		{
			return $this->date;
		}
		$this->date = $date;
	}

	public function Name($name = "")
	{
		if ($name == "")
		{
			return $this->name;
		}
		$this->name = $name;
	}

	public function Merchant($merchant = "")
	{
		if ($merchant == "")
		{
			return $this->merchant;
		}
		$this->merchant = $merchant;
	}

	public function Amount($amount = "")
	{
		if ($amount == "")
		{
			return $this->amount;
		}
		$this->amount = $amount;
	}
	
	public function Reason($reason = "")
	{
		if ($reason == "")
		{
			return $this->reason;
		}
		$this->reason = $reason;
	}
	
	public function Valid($valid = "")
	{
		if ($valid== "")
		{
			return $this->valid;
		}
		$this->valid= $valid;
	}
	
	public function Canceled($canceled = "")
	{
		if ($canceled== "")
		{
			return $this->canceled;
		}
		$this->canceled= $canceled;
	}

	public function Check($userList)
	{
		
		$check_1 = false;
		$check_2 = false;
		$check_3 = false;	
		

		if ($this->name != "" && $this->merchant != "" && $this->amount != "" && $this->reason != "")
		{
			$check_1 = true;
		}
		else
		{
			print("\n");	
			print("Veuillez remplir tous les champs");
		}
		
		if (is_numeric($this->amount))
		{
			$check_2 = true;
		}
		else
		{
			print("\n");
			print("Veuillez saisire un montant valide");
		}

		foreach($userList as $value)
		{
			if ($value->Name() == $this->name)
			{
				$check_3 = true;
			}
		}
			
			if ($check_3 == false)
		{
			print("\n");	
			print("Veuillez utiliser un identifiant reconnu");
		}

		if ($check_1 == true && $check_2 == true && $check_3 == true) 
		{
			$this->Valid(true);
		}
	}
	public function Prompt()
	{
		$this->name = readline("Nom :\t");
		$this->merchant = readline("Marchand :\t");
		$this->amount = readline("Montant :\t");
		$this->reason = readline("Motif :\t");
	}


	public function Display()
	{
		printf("\n");
		printf("Date : %s", $this->date);
		printf("\t");
		printf("Nom : %s", $this->name);
		printf("\t");
		printf("Marchand : %s", $this->merchant);
		printf("\t");
		printf("Montant : %d",$this->amount);
		printf("\t");
		printf("Motif : %s", $this->reason);
		printf("\t");
		printf("Validite : %s", $this->valid);
		printf("\t");
		printf("Annule : %s", $this->canceled);
	}

	public function Write($file)
	{
		if ($this->valid == true) 
		{
		$handle = fopen($file, "a");
		fprintf($handle, "%s,\"%s\",\"%s\",%d,\"%s\",%s,%s\n",
				$this->date, $this->name, $this->merchant, $this->amount, $this->reason, $this->valid, $this->canceled);
		fclose($handle);
		}
	}

	public function Historic($file)
	{
		$handle = fopen($file, "r");
		while (($historic = fgetcsv($handle,1000,',',"\"")) == true)
		{
			$req = new Request();
			$req->Date($historic[0]);
			$req->Name($historic[1]);
			$req->Merchant($historic[2]);
			$req->Amount($historic[3]);
			$req->Reason($historic[4]);
			$req->Valid($historic[5]);
			$req->Canceled($historic[6]);

			$req->Display();
		}
		fclose($handle);
	}

				
}

class Card
{
	private $owner;
	private $number;
	private $security;
	private $validity;
	private $code;

	public function __construct()
	{
		$this->owner = "Loic Remy";
		$this->number = "5500 20 18 4004 001494";
		$this->security = "420";
		$this->validity = "12/27";
		$this->code = "mon code secret";
	}

	public function Display($request)
	{
		if($request->Valid() == true)
		{
			print("\n");
			printLine('=', 80);
			print("\n");
			printLine(' ', (80-9)/2);
			print(" C A R D ");
			printLine(' ', 80-9);
			print("\n");
			printLine('_', 80);
			printf("\n\t\tTitulaire :\t\t%s", $this->owner);
			printf("\n\t\tNumero :\t\t%s", $this->number);
			printf("\n\t\tNo de securite :\t%s", $this->security);
			printf("\n\t\tEcheance :\t\t%s", $this->validity);
			printf("\n\t\t3D secure :\t\t%s", $this->code);
			print("\n");
			printLine('=', 80);
			print("\n");
		}
		else 
		{
			print("\n");
			print("Vous n'avez pas acces aux informations demandees");
		return 1;
		}
	}
}



class User
{
	private $name;

	public function __construct($name, &$list)
	{
		$this->name = $name;
		$list[] = $this;
	}

	public function Name($name = "")
	{
		if ($name == "")
		{
			return $this->name;
		}
		$this->name = $name;
	}

	public function AddtoList(&$list)
	{
		$list[] = $this;
	}
}

class UserConnect
{
        private $file;
        private $mode;
        private $handle;

        public function __construct($file, $mode)
        {
                $this->file = $file;
                $this->mode = $mode;
                $this->handle = fopen($file, $mode);
        }

        public function Mode($mode)
        {
                if ($mode != "") 
                {
                        fclose($this->handle);
                        $this->mode = $mode;
                        $this->handle = fopen($file, $mode);
                }
                return $this->mode;      
        }

        
}
$userCon = new UserConnect("users.txt","r");
$userList = array();
while (($data = fgetcsv($userCon,100)) != false):
        {
                new User($data[0], $userList);
        }

$request = new Request;
$card = new Card;

if ($argv[1] === "h") 
{
	$request->Historic("log.txt");
}
else if ($argv[1] === "u" && ctype_aplha($argv[2]))
{
        $userCon = new UserConnect("users.txt","r");₩
}
else if ($argv[1] === "u" && $argv[2] === NULL)
{
        foreach ($userList as $name) {
               printf("%s", $name);
        }
}
else
{

$request->Prompt();
$request->Check($userList);
$card->Display($request);
$request->Write("log.txt");
}

/*
print_r($userList);
print_r($request);
*/
?>
