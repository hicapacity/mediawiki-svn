#ifndef DTD_H
#define DTD_H 1

#define DTD "\
<?xml version=\"1.0\" encoding=\"ISO-8859-1\" standalone=\"yes\"?>\n\
<!DOCTYPE GANGLIA_XML [\n\
   <!ELEMENT GANGLIA_XML (GRID|CLUSTER|HOST)*>\n\
      <!ATTLIST GANGLIA_XML VERSION CDATA #REQUIRED>\n\
      <!ATTLIST GANGLIA_XML SOURCE CDATA #REQUIRED>\n\
   <!ELEMENT GRID (CLUSTER | GRID | HOSTS | METRICS)*>\n\
      <!ATTLIST GRID NAME CDATA #REQUIRED>\n\
      <!ATTLIST GRID AUTHORITY CDATA #REQUIRED>\n\
      <!ATTLIST GRID LOCALTIME CDATA #IMPLIED>\n\
   <!ELEMENT CLUSTER (HOST | HOSTS | METRICS)*>\n\
      <!ATTLIST CLUSTER NAME CDATA #REQUIRED>\n\
      <!ATTLIST CLUSTER OWNER CDATA #IMPLIED>\n\
      <!ATTLIST CLUSTER LATLONG CDATA #IMPLIED>\n\
      <!ATTLIST CLUSTER URL CDATA #IMPLIED>\n\
      <!ATTLIST CLUSTER LOCALTIME CDATA #REQUIRED>\n\
   <!ELEMENT HOST (METRIC)*>\n\
      <!ATTLIST HOST NAME CDATA #REQUIRED>\n\
      <!ATTLIST HOST IP CDATA #REQUIRED>\n\
      <!ATTLIST HOST LOCATION CDATA #IMPLIED>\n\
      <!ATTLIST HOST REPORTED CDATA #REQUIRED>\n\
      <!ATTLIST HOST TN CDATA #IMPLIED>\n\
      <!ATTLIST HOST TMAX CDATA #IMPLIED>\n\
      <!ATTLIST HOST DMAX CDATA #IMPLIED>\n\
      <!ATTLIST HOST GMOND_STARTED CDATA #IMPLIED>\n\
   <!ELEMENT METRIC (EXTRA_DATA*)>\n\
      <!ATTLIST METRIC NAME CDATA #REQUIRED>\n\
      <!ATTLIST METRIC VAL CDATA #REQUIRED>\n\
      <!ATTLIST METRIC TYPE (string | int8 | uint8 | int16 | uint16 | int32 | uint32 | float | double | timestamp) #REQUIRED>\n\
      <!ATTLIST METRIC UNITS CDATA #IMPLIED>\n\
      <!ATTLIST METRIC TN CDATA #IMPLIED>\n\
      <!ATTLIST METRIC TMAX CDATA #IMPLIED>\n\
      <!ATTLIST METRIC DMAX CDATA #IMPLIED>\n\
      <!ATTLIST METRIC SLOPE (zero | positive | negative | both | unspecified) #IMPLIED>\n\
      <!ATTLIST METRIC SOURCE (gmond) 'gmond'>\n\
   <!ELEMENT EXTRA_DATA (EXTRA_ELEMENT*)>\n\
   <!ELEMENT EXTRA_ELEMENT EMPTY>\n\
      <!ATTLIST EXTRA_ELEMENT NAME CDATA #REQUIRED>\n\
      <!ATTLIST EXTRA_ELEMENT VAL CDATA #REQUIRED>\n\
   <!ELEMENT HOSTS EMPTY>\n\
      <!ATTLIST HOSTS UP CDATA #REQUIRED>\n\
      <!ATTLIST HOSTS DOWN CDATA #REQUIRED>\n\
      <!ATTLIST HOSTS SOURCE (gmond | gmetad) #REQUIRED>\n\
   <!ELEMENT METRICS (EXTRA_DATA*)>\n\
      <!ATTLIST METRICS NAME CDATA #REQUIRED>\n\
      <!ATTLIST METRICS SUM CDATA #REQUIRED>\n\
      <!ATTLIST METRICS NUM CDATA #REQUIRED>\n\
      <!ATTLIST METRICS TYPE (string | int8 | uint8 | int16 | uint16 | int32 | uint32 | float | double | timestamp) #REQUIRED>\n\
      <!ATTLIST METRICS UNITS CDATA #IMPLIED>\n\
      <!ATTLIST METRICS SLOPE (zero | positive | negative | both | unspecified) #IMPLIED>\n\
      <!ATTLIST METRICS SOURCE (gmond) 'gmond'>\n\
]>\n"

#endif
