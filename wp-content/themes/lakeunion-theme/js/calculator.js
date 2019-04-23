// Functions
var CheckIE4 = false;
if(navigator.appName.indexOf("Microsoft") != -1  &&  parseInt(navigator.appVersion) >= 4)
	CheckIE4 = true;

var cache = '';
var globalMntlyPay = '';
var theIndid;

var answer= '';

// Validate the Fields

function readIndid()
{
	theIndid = getQueryVariable("indid");
	setdefaults();
}

function setdefaults()
{
	switch (theIndid)
	{
		case '1':
		//calc_term_values = '60,84,120,144,180,240';
		//calc_term_text = '5 Years,7 Years,10 Years,12 Years,15 Years,20 Years';
		document.getElementById('calcMonths').value = '60';
		document.getElementById('calcYears').value = '5';
		document.getElementById('calcAnnualRate').value = '7.00';
		break;

		case '2':
		//calc_term_values = '12,24,36,48,60,72,84';
		//calc_term_text = '12 Months,24 Months,36 Months,48 Months,60 Months,72 Months,84 Months';
		document.getElementById('calcMonths').value = '36'; 
		document.getElementById('calcYears').value = '3';
		document.getElementById('calcAnnualRate').value = '13.9';
		break;

		case '3':
		//calc_term_values = '12,24,36,48,60,72,84';
		//calc_term_text = '12 Months,24 Months,36 Months,48 Months,60 Months,72 Months,84 Months';
		document.getElementById('calcMonths').value = '84';
		document.getElementById('calcYears').value = '7';
		document.getElementById('calcAnnualRate').value = '13.9';
		break; 

		case '4':
		//calc_term_values = '12,24,36,48,60,72,84';
		//calc_term_text = '12 Months,24 Months,36 Months,48 Months,60 Months,72 Months,84 Months';
		document.getElementById('calcMonths').value = '24';
		document.getElementById('calcYears').value = '2';
		document.getElementById('calcAnnualRate').value = '8.00';
		break;

		case '5': 
		//calc_term_values = '12,24,36,48,60,72,84';
		//calc_term_text = '12 Months,24 Months,36 Months,48 Months,60 Months,72 Months,84 Months';
		document.getElementById('calcMonths').value = '24';
		document.getElementById('calcYears').value = '2';
		document.getElementById('calcAnnualRate').value = '8.00';
		break;

		case '6': 
		//calc_term_values = '12,24,36,48,60,72,84';
		//calc_term_text = '12 Months,24 Months,36 Months,48 Months,60 Months,72 Months,84 Months';
		document.getElementById('calcMonths').value = '36';
		document.getElementById('calcYears').value = '3';
		document.getElementById('calcAnnualRate').value = '8.00';
		break;

		case '7': 
		//calc_term_values = '12,24,36,48,60,72,84';
		//calc_term_text = '12 Months,24 Months,36 Months,48 Months,60 Months,72 Months,84 Months';
		document.getElementById('calcMonths').value = '36';
		document.getElementById('calcYears').value = '3';
		document.getElementById('calcAnnualRate').value = '8.00';
		break;
		
		default:
		document.getElementById('calcMonths').value = '60';
		document.getElementById('calcYears').value = '5';
		document.getElementById('calcAnnualRate').value = '7.00';
		break;

	} 

}

function OnPriceChange(objSrc)
{
	if(FieldValidate()) 
	{ 
		if(DollarValuesRead(objSrc.value) < DollarValuesRead(document.getElementById('calcDownPayment').value)) 
		{ 
			document.getElementById('calcDownPayment').value = objSrc.value;
			pcDownPayPercentage();
		} 
		else 
		{
			pcDownPaymentAmt(); 
			pcMonthlyPayment();
		}
	} 
	else 
		objSrc.value=cache;
}

function OnDownPaymentAmtChange(objSrc)
{
	if (objSrc != null)
	{
		if(objSrc.value != "" && FieldValidate()) 
		{ 
			pcDownPayPercentage(); 
			pcMonthlyPayment(); 
		} 
		else 
			objSrc.value=cache;
	}
}

function OnDownPaymentPtgeChange(objSrc)
{
	if(FieldValidate())
	{ 
		pcDownPaymentAmt(); 
		pcMonthlyPayment(); 
	} 
	else 
		objSrc.value=cache;
}

function OnLoanTermMnChange(objSrc)
{
	if(FieldValidate())
	{
		pcYears();
		pcMonthlyPayment();
	} 
	else 
		objSrc.value=cache;
}

function OnLoanTermYrChange(objSrc)
{
	if(FieldValidate()) 
	{
		pcMonths();
		pcMonthlyPayment();
	} 
	else
		objSrc.value=cache;
}

function OnAirChange(objSrc)
{
	if(FieldValidate()) 
		pcMonthlyPayment();
	else 
		objSrc.value=cache;
}

function FieldValidate() 
{
	var ErrMsg = '';
	if(!DollarValuesCheck(document.getElementById('calcPrice').value))
		ErrMsg += ' Valid Price \n';
	if(!DollarValuesCheck(document.getElementById('calcDownPayment').value))
		ErrMsg += ' Valid Down Payment in Dollars \n';
	if(!FloatValuesCheck(document.getElementById('calcDownPaymentPercentage').value))
		ErrMsg += ' Valid Down Payment in Percent \n';
	if(!IntValuesCheck(document.getElementById('calcMonths').value))
		ErrMsg += ' Valid Loan Term in Months \n';
	if(!FloatValuesCheck(document.getElementById('calcYears').value))
		ErrMsg += ' Valid Loan Term in Years \n';
	if(!FloatValuesCheck(document.getElementById('calcAnnualRate').value))
	{
		document.getElementById('calcAnnualRate').value="7.0";
		ErrMsg += ' Valid Annual Interest Rate \n';
		document.getElementById('calcAnnualRate').value="7.0";
	}
	if(ErrMsg == '')
		return true;
	else 
	{
		alert(' Please enter: \n' + ErrMsg);
		return false;
	}
}

function MonthlyPaymentValidate()
{
	var ErrMsg = '';
	if(document.getElementById('calcDownPayment').value == "" || document.getElementById('calcDownPayment').value == null)
		pcDownPaymentAmt();
	if(FieldValidate())
	{
		if(document.getElementById('calcPayment').value != '' && !DollarValuesCheck(document.getElementById('calcPayment').value))
		{	
			ErrMsg += ' Valid Monthly Payment Amount \n';
			document.getElementById('calcPayment').value="";
		}
		if(ErrMsg == '')
			return true;
		else 
		{
			alert(' Please enter: \n' + ErrMsg);
			return false;
		}
	}
}

// Check Float Values
function FloatValuesCheck(field)
{
	var intval = field;
	if(intval >= 0)
	{
		if(intval.indexOf(".") != -1) 
		{
			while(intval.charAt(intval.length-1) == "0")
				intval = intval.substring(0,intval.length-1);
			if(intval.charAt(intval.length-1) == ".")
				intval = intval.substring(0,intval.length-1);
		}

		if("" + parseFloat(intval) != intval)
			return false;
		else
			return true;
	}
	else
		return false;
}

//Check Integer Values
function IntValuesCheck(field) 
{
	var intval = field;
	if(intval >= 0)
	{
		if(isNaN(intval))
			return false;
		else 
		{
			field.value = '' + parseInt(intval)
			return true;
		}
	}
	else
		return false;
}

// Check Dollar Values
function DollarValuesCheck(field) 
{
	var floatval = DollarValuesRead(field);
	if(isNaN(floatval))
		return false;
	else 
	{
		str = ConvertFloatToDollar(floatval);
		field.value = str;
		return true;
	}
}

// Read Dollar Values
function DollarValuesRead(field) 
{
	var str = field;
	if (field == "")
		return 0;
	else
	{
		if(str.charAt(0) == "$")
			str = str.substring(1, str.length);
		
		var pos = str.lastIndexOf(",");
		while(pos != -1) 
		{
			str = str.substring(0,pos) + str.substring(pos+1, str.length);
			pos = str.lastIndexOf(",", pos);
		}
		return parseFloat(str);
	}
}

// Convert Float to Dollar
function ConvertFloatToDollar(floatval) 
{
	var str = "" + Math.round(floatval)

	pos = str.length; 
	pos -= 4;
	while(pos >= 0) 
	{
		str = str.substring(0,pos+1) + "," + str.substring(pos+1, str.length);
		pos -= 3;
	}

	return str;
}

// Term Months
function pcMonths() 
{
	var tYr = parseFloat(document.getElementById('calcYears').value);
	var tMon = Math.round(tYr * 12.0);
	tYr = parseFloat(tMon) / 12.0;
	document.getElementById('calcYears').value = "" + tYr;
	document.getElementById('calcMonths').value = "" + tMon;

}

// Term Years
function pcYears() 
{
	var tMon = parseInt(document.getElementById('calcMonths').value);
	var tYr = parseFloat(tMon) / 12.0;
	document.getElementById('calcYears').value = "" + tYr;
	document.getElementById('calcMonths').value = "" + tMon;

}

// Price or Montly Payment Call
function pcCalcCall()
{
	var MntlyPay = document.getElementById('calcPayment').value;
	if (MntlyPay == globalMntlyPay)
		if(document.getElementById('calcPrice').value != "")
			pcMonthlyPayment();
		else
			alert('Please Enter Amount For Price');
	else
		if(document.getElementById('calcMonths').value !="")
			pcCalcPrice();
		else
			alert('Please Enter Amount For Monthly Payment');
}

// Calc Price based on Monthly Payment
function pcCalcPrice()
{
	if(document.getElementById('calcPayment').value != answer)
	{
		var AnnualInt  = parseFloat(document.getElementById('calcAnnualRate').value);
		var MonthlyInt = AnnualInt / (12.0 * 100.0);
		var LenMonths  = parseInt(document.getElementById('calcMonths').value);
		var MonthlyPay = document.getElementById('calcPayment').value;
	
		if(MonthlyInt == 0)
			var Principle = MonthlyPay / LenMonths;
		else
			var Principle = MonthlyPay / ( MonthlyInt / ( 1 - Math.pow((1 + MonthlyInt), -LenMonths) ) );
			Principle = Math.round(Principle * 100) / 100;
			priceVal = ConvertFloatToDollar(Principle);
			if(priceVal != "NaN")
				document.getElementById('calcPrice').value = priceVal;
	}
}


// Calc Monthly Payments
function pcMonthlyPayment() 
{
	var Principle  = DollarValuesRead(document.getElementById('calcPrice').value) - DollarValuesRead(document.getElementById('calcDownPayment').value);
	var AnnualInt  = parseFloat(document.getElementById('calcAnnualRate').value);
	var MonthlyInt = AnnualInt / (12.0 * 100.0);
	var LenMonths  = parseInt(document.getElementById('calcMonths').value);
	if(MonthlyInt == 0)
		var MonthlyPay = Principle / LenMonths;
	else
		var MonthlyPay = Principle * ( MonthlyInt / ( 1 - Math.pow((1 + MonthlyInt), -LenMonths) ) );
	MonthlyPay = Math.round(MonthlyPay * 100) / 100;

	globalMntlyPay = MonthlyPay;
	monthlyVal = ConvertFloatToDollar(MonthlyPay);
	answer = monthlyVal;
	document.getElementById('calcPayment').value = monthlyVal;
}

// Calc Down Payment
function pcDownPayment() 
{
	var AnnualInt  = parseFloat(document.getElementById('calcAnnualRate').value);
	var MonthlyInt = AnnualInt / (12.0 * 100.0);
	var LenMonths  = parseInt(document.getElementById('calcMonths').value);
	var MonthlyPay = DollarValuesRead(document.getElementById('calcPayment').value);
	var Principle  = DollarValuesRead(document.getElementById('calcPrice').value) - DollarValuesRead(document.getElementById('calcDownPayment').value);
	var OldDownPay = DollarValuesRead(document.getElementById('calcDownPayment').value);
	var EffPrinciple;

	if(MonthlyInt == 0)
		EffPrinciple = MonthlyPay * LenMonths;
	else
		EffPrinciple = MonthlyPay * ((1 - Math.pow((1 + MonthlyInt), -LenMonths)) / MonthlyInt);

	var NewDownPay = OldDownPay + (Principle - EffPrinciple);
	document.getElementById('calcDownPayment').value = "" + NewDownPay;
	DollarValuesCheck(document.getElementById('calcDownPayment').value);
	pcDownPayPercentage();
	pcMonthlyPayment();
}

// Calc Down Payment %
function pcDownPayPercentage() 
{
	var HomePrice  = DollarValuesRead(document.getElementById('calcPrice').value);
	var DownPay = DollarValuesRead(document.getElementById('calcDownPayment').value);
	var DownPayPerc = 100 * DownPay / HomePrice;

	if(DownPayPerc >= 0  &&  DownPayPerc <= 100) 
	{
		var DownPayPercStr = "" + DownPayPerc;

		var pos = DownPayPercStr.indexOf(".");
		if(DownPayPercStr.length > pos + 4)
			DownPayPercStr = DownPayPercStr.substring(0,pos+4);
		
		document.getElementById('calcDownPaymentPercentage').value = DownPayPercStr;
	}
	else if(DownPayPerc < 0) 
	{
		document.getElementById('calcDownPaymentPercentage').value = "0";
		pcDownPaymentAmt();
	}
}

// Calc Down Payment Amount
function pcDownPaymentAmt() 
{
	var HomePrice  = DollarValuesRead(document.getElementById('calcPrice').value);
	var DownPayPerc = parseFloat(document.getElementById('calcDownPaymentPercentage').value);
	if(DownPayPerc < 0) 
	{
		document.getElementById('calcDownPaymentPercentage').value = "0";
		pcDownPaymentAmt();
	}
	else if(DownPayPerc > 100) 
	{
		document.getElementById('calcDownPaymentPercentage').value = "100";
		pcDownPaymentAmt();
	}
	else 
	{
		var DownPay = HomePrice * DownPayPerc / 100;
		DownPay = ConvertFloatToDollar(DownPay);
		document.getElementById('calcDownPayment').value = "" + DownPay;
	}
}

function pcSave() 
{
	var CookieValAir="";
	var CookieValDPAmt = "";
	var CookieValDPPtage = "";
	var AlertMsg="";
	var expires
	
	if(document.getElementById('calcSaveAnnualRate').checked) 
	{
		CookieValAir+= document.getElementById('calcAnnualRate').value;
		AlertMsg += "Annual Interest Rate: " + document.getElementById('calcAnnualRate').value + "%\n";
	}
	if(document.getElementById('calcSaveDownPayment').checked) 
	{
		if(document.getElementById('calcSaveDPDollars').checked) 
		{
			CookieValDPAmt += DollarValuesRead(document.getElementById('calcDownPayment').value);
			AlertMsg += "Down payment amount: $" + document.getElementById('calcDownPayment').value + "\n";
		}

		if(document.getElementById('calcSaveDPPercentage').checked) 
		{
			CookieValDPPtage += document.getElementById('calcDownPaymentPercentage').value;
			AlertMsg += "Down payment percentage: " + document.getElementById('calcDownPaymentPercentage').value + "%\n";
		}
	}
	
	if((CookieValAir != "") || (CookieValDPAmt != "") || (CookieValDPPtage != ""))
	{
		expires = new Date();
		expires.setTime(expires.getTime() + (365 * 24 * 60 * 60 * 1000));  
		document.cookie = 'AIR=' + CookieValAir + '; path=/; expires=' + expires.toGMTString();
		document.cookie = 'DPA=' + CookieValDPAmt + '; path=/; expires=' + expires.toGMTString();
		document.cookie = 'DPP=' + CookieValDPPtage + '; path=/; expires=' + expires.toGMTString();
		alert("Saved:\n" + AlertMsg);
	}
	else
		alert('Select either "Annual Interest Rate" and/or "Down Payment".');
}

// End of Functions

// Read the Cookies Value
function Init()
{	
	// Read params in the query string
	var theMsrp = getQueryVariable("msrp");
	var thePrice = getQueryVariable("Price");
	var theDnPay = getQueryVariable("DnPay");
	var thePtge = getQueryVariable("Ptge");
	var theTmMn = getQueryVariable("TmMn");
	var theTmYr = getQueryVariable("TmYr");
	var theAir = getQueryVariable("Air");
	var thisIndid = getQueryVariable("indid");

	// Read params from cookies
	var airCookie = getCookie('AIR');
	var dnpayCookie = getCookie('DPA');
	var ptgeCookie = getCookie('DPP');
	
	// Load Fields
	// Price
	if ((theMsrp != "" ) && (theMsrp != null))
		document.getElementById('calcPrice').value = theMsrp;
		
	// Down Payment
	if ((theDnPay != "" ) && (theDnPay != null))
	{
		document.getElementById('calcDownPayment').value = theDnPay;
    	OnDownPaymentAmtChange(document.getElementById('calcDownPayment'));
	}
	else if (dnpayCookie !== null)
	{
		document.getElementById('calcDownPayment').value = dnpayCookie;
    	OnDownPaymentAmtChange(document.getElementById('calcDownPayment'));
	}

	// Down %
	if ((thePtge != "") && (thePtge != null))
	{
		document.getElementById('calcDownPaymentPercentage').value = thePtge;	
    	OnDownPaymentPtgeChange(document.getElementById('calcDownPayment'));
	}
	else if (ptgeCookie != null)
	{
		document.getElementById('calcDownPaymentPercentage').value = ptgeCookie;
    	OnDownPaymentPtgeChange(document.getElementById('calcDownPayment'));
	}
	
	// indid
	if ((thisIndid == "") || (thisIndid == null))
	{
		document.getElementById('calcAnnualRate').value = "7.00";
		document.getElementById('calcMonths').value = "60";
		document.getElementById('calcYears').value = "5";
	}
	else
		readIndid();
	
	// Air
	if ((theAir != "") && (theAir != null))
		document.getElementById('calcAnnualRate').value = theAir;
	else if (airCookie != null)
		document.getElementById('calcAnnualRate').value = airCookie;

	// TmMn
	if ((theTmMn != "") && (theTmMn != null))
		document.getElementById('calcMonths').value= theTmMn;

	// TmYr			
	if ((theTmYr != "") && (theTmYr != null))
		document.getElementById('calcYears').value= theTmYr;
		
	pcMonthlyPayment();
}

function getQueryVariable(variable)
{
	var query = window.location.search.substring(1);
	var vars = query.split("&");
	var strResult = "";
	for (var i=0;i<vars.length;i++) 
	{
		var pair = vars[i].split("=");
		if (pair[0] == variable) 
			strResult = pair[1];
	} 
	return strResult;
}

function getCookie(name)
{
	var dc = document.cookie;
	var prefix = name + "=";
	var begin = dc.indexOf("; " + prefix);
	if (begin == -1)
	{
		begin = dc.indexOf(prefix);
		if (begin != 0)
		    return null;
	}
	else
		begin += 2;
	var end = document.cookie.indexOf(";", begin);
	if (end == -1)
		end = dc.length;
	return unescape(dc.substring(begin + prefix.length, end));
}