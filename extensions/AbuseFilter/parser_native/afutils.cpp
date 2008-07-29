#include "afutils.h"
#include <math.h>
#include <boost/regex.hpp>

AFPData af_boolInvert( AFPData value ) {
	bool bVal = !value.toBool();
	
	AFPData d(bVal);
	
	return d;
}

AFPData af_pow( AFPData base, AFPData exponent ) {
	float b = base.toFloat();
	float e = exponent.toFloat();
	
	float result = pow(b,e);
	
	return AFPData(result);
}

AFPData af_keywordIn( AFPData needle, AFPData haystack ) {
	string n = needle.toString();
	string h = haystack.toString();
	
	bool result = h.find(n,0) != h.npos;
	
	return AFPData(result);
}

AFPData af_unaryMinus( AFPData data ) {
	float v = data.toFloat();
	
	return AFPData(-v);
}

AFPData af_boolOp( AFPData a, AFPData b, string op ) {
	bool v1 = a.toBool();
	bool v2 = b.toBool();
	
	if (op == "|") {
		return AFPData( v1 || v2 );
	} else if (op == "&") {
		return AFPData( v1 && v2 );
	} else if (op == "^") {
		return AFPData( (v1 || v2) && !(v1 && v2) );
	}
	
	throw new AFPException( "Invalid boolean operation." );
}

AFPData af_compareOp( AFPData a, AFPData b, string op ) {
	string s1 = a.toString();
	string s2 = b.toString();
	
	float f1 = a.toFloat();
	float f2 = b.toFloat();
	
	unsigned int t1 = a.type;
	unsigned int t2 = b.type;
	
	if (op == "==") {
		return AFPData( s1 == s2 );
	} else if (op == "!=") {
		return AFPData( s1 != s2 );
	} else if (op == "===") {
		return AFPData( s1 == s2 && t1 == t2 );
	} else if (op == "!==") {
		return AFPData( s1 != s2 || t1 != t2 );
	} else if (op == ">") {
		return AFPData( f1 > f2 );
	} else if (op == "<") {
		return AFPData( f1 < f2 );
	} else if (op == ">=") {
		return AFPData( f1 >= f2 );
	} else if (op == "<=") {
		return AFPData( f1 <= f2 );
	}
	throw new AFPException( "Invalid comparison type" );
}

AFPData af_mulRel( AFPData a, AFPData b, string op ) {
	float f1 = a.toFloat();
	float f2 = b.toFloat();
	
	if (op == "*") {
		return AFPData( f1 * f2 );
	} else if (op == "/") {
		return AFPData( f1 / f2 );
	} else if (op == "%") {
		int i1 = a.toInt();
		int i2 = b.toInt();
		
		return AFPData( (double)(i1 % i2) );
	}
	
	throw new AFPException( "Invalid multiplication-related operator" );
}

AFPData af_sum( AFPData a, AFPData b ) {
	if (a.type == D_STRING || b.type == D_STRING) {
		return AFPData( a.toString() + b.toString() );
	} else {
		return AFPData( a.toFloat() * b.toFloat() );
	}
}

AFPData af_sub( AFPData a, AFPData b ) {
	return AFPData( a.toFloat() - b.toFloat() );
}

bool isInVector( string needle, vector<string> haystack ) {
	for( vector<string>::iterator it=haystack.begin(); it!=haystack.end(); ++it ) {
		string test = *it;
		if (test == needle.c_str()) { return true; }
	}
	
	return false;
}

AFPData af_keyword( string keyword, AFPData a, AFPData b ) {
	if (keyword == "in") {
		string needle = a.toString();
		string haystack = b.toString();
		
		bool result = (haystack.find( needle, 0 ) != haystack.npos);
		
		return AFPData( result );
	} else if (keyword == "like") {
		boost::regex rx( b.toString() );
		string test = a.toString();
		
		bool result = regex_match( test, rx );
		
		return AFPData( result );
	}
	
	throw new AFPException( "Unknown keyword %s", keyword );
}
