/*
 * MediaWiki import/export processing tools
 * Copyright 2005 by Brion Vibber
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 *
 * $Id$
 */

package org.mediawiki.importer;

import java.io.IOException;
import java.io.InputStream;
import java.util.Calendar;
import java.util.GregorianCalendar;
import java.util.HashMap;
import java.util.Map;
import java.util.TimeZone;

import javax.xml.parsers.ParserConfigurationException;
import javax.xml.parsers.SAXParser;
import javax.xml.parsers.SAXParserFactory;

import org.xml.sax.Attributes;
import org.xml.sax.SAXException;
import org.xml.sax.helpers.DefaultHandler;

public class XmlDumpReader  extends DefaultHandler {
	InputStream input;
	DumpWriter writer;
	
	private char[] buffer;
	private int len;
	
	Siteinfo siteinfo;
	Page page;
	boolean pageSent;
	Contributor contrib;
	Revision rev;
	int nskey;
	
	/**
	 * Initialize a processor for a MediaWiki XML dump stream.
	 * Events are sent to a single DumpWriter output sink, but you
	 * can chain multiple output processors with a MultiWriter.
	 * @param inputStream Stream to read XML from.
	 * @param writer Output sink to send processed events to.
	 */
	public XmlDumpReader(InputStream inputStream, DumpWriter writer) {
		input = inputStream;
		this.writer = writer;
		buffer = new char[4096];
		len = 0;
	}
	
	/**
	 * Reads through the entire XML dump on the input stream, sending
	 * events to the DumpWriter as it goes. May throw exceptions on
	 * invalid input or due to problems with the output.
	 * @throws IOException
	 */
	public void readDump() throws IOException {
		try {
			SAXParserFactory factory = SAXParserFactory.newInstance();
			SAXParser parser = factory.newSAXParser();
	
			parser.parse(input, this);
		} catch (ParserConfigurationException e) {
			throw new IOException(e.getMessage());
		} catch (SAXException e) {
			throw new IOException(e.getMessage());
		}
		writer.close();
	}
	
	// --------------------------
	// SAX handler interface methods:
	
	private static final Map startElements = new HashMap(64);
	private static final Map endElements = new HashMap(64);
	static {
		startElements.put("revision","revision");
		startElements.put("contributor","contributor");
		startElements.put("page","page");
		startElements.put("mediawiki", "mediawiki");
		startElements.put("siteinfo","siteinfo");
		startElements.put("namespaces","namespaces");
		startElements.put("namespace","namespace");

		endElements.put("base","base");
		endElements.put("case","case");
		endElements.put("comment","comment");
		endElements.put("contributor","contributor");
		endElements.put("generator","generator");
		endElements.put("id","id");
		endElements.put("ip","ip");
		endElements.put("mediawiki", "mediawiki");
		endElements.put("minor","minor");
		endElements.put("namespaces","namespaces");
		endElements.put("namespace","namespace");
		endElements.put("page","page");
		endElements.put("restrictions","restrictions");
		endElements.put("revision","revision");
		endElements.put("siteinfo","siteinfo");
		endElements.put("sitename","sitename");
		endElements.put("text","text");
		endElements.put("timestamp","timestamp");
		endElements.put("title","title");
		endElements.put("username","username");
	}
	
	public void startElement(String uri, String localname, String qName, Attributes attributes) throws SAXException {
		// Clear the buffer for character data; we'll initialize it
		// if and when character data arrives -- at that point we
		// have a length.
		len = 0;
		try {
			qName = (String)startElements.get(qName);
			if (qName == null)
				return;
			// frequent tags:
			if (qName == "revision") openRevision();
			else if (qName == "contributor") openContributor();
			else if (qName == "page") openPage();
			// rare tags:
			else if (qName == "mediawiki") openMediaWiki();
			else if (qName == "siteinfo") openSiteinfo();
			else if (qName == "namespaces") openNamespaces();
			else if (qName == "namespace") openNamespace(attributes);
		} catch (IOException e) {
			throw new SAXException(e);
		}
	}
	
	public void characters(char[] ch, int start, int length) {
		if (buffer.length < len + length) {
			int maxlen = buffer.length * 2;
			if (maxlen < len + length)
				maxlen = len + length;
			char[] tmp = new char[maxlen];
			System.arraycopy(buffer, 0, tmp, 0, len);
			buffer = tmp;
		}
		System.arraycopy(ch, start, buffer, len, length);
		len += length;
	}
	
	public void endElement(String uri, String localname, String qName) throws SAXException {
		try {
			qName = (String)endElements.get(qName);
			if (qName == null)
				return;
			// frequent tags:
			if (qName == "id") readId();
			else if (qName == "revision") closeRevision();
			else if (qName == "timestamp") readTimestamp();
			else if (qName == "text") readText();
			else if (qName == "contributor") closeContributor();
			else if (qName == "username") readUsername();
			else if (qName == "ip") readIp();
			else if (qName == "comment") readComment();
			else if (qName == "minor") readMinor();
			else if (qName == "page") closePage();
			else if (qName == "title") readTitle();
			else if (qName == "restrictions") readRestrictions();
			// rare tags:
			else if (qName == "mediawiki") closeMediaWiki();
			else if (qName == "siteinfo") closeSiteinfo();
			else if (qName == "sitename") readSitename();
			else if (qName == "base") readBase();
			else if (qName == "generator") readGenerator();
			else if (qName == "case") readCase();
			else if (qName == "namespaces") closeNamespaces();
			else if (qName == "namespace") closeNamespace();
		} catch (IOException e) {
			throw new SAXException(e);
		}
	}

	// ----------
	
	void openMediaWiki() throws IOException {
		siteinfo = null;
		writer.writeStartWiki();
	}
	
	void closeMediaWiki() throws IOException {
		writer.writeEndWiki();
		siteinfo = null;
	}
	
	// ------------------
		
	void openSiteinfo() {
		siteinfo = new Siteinfo();
	}
	
	void closeSiteinfo() throws IOException {
		writer.writeSiteinfo(siteinfo);
	}

	private String bufferContents() {
		return len == 0 ? "" : new String(buffer, 0, len);
	}
	
	void readSitename() {
		siteinfo.Sitename = bufferContents();
	}
	
	void readBase() {
		siteinfo.Base = bufferContents();
	}
	
	void readGenerator() {
		siteinfo.Generator = bufferContents();
	}
	
	void readCase() {
		siteinfo.Case = bufferContents();
	}
	
	void openNamespaces() {
		siteinfo.Namespaces = new NamespaceSet();
	}
	
	void openNamespace(Attributes attribs) {
		nskey = Integer.parseInt(attribs.getValue("key"));
	}
	
	void closeNamespace() {
		siteinfo.Namespaces.add(nskey, bufferContents());
	}

	void closeNamespaces() {
		// NOP
	}
	
	// -----------
	
	void openPage() {
		page = new Page();
		pageSent = false;
	}
	
	void closePage() throws IOException {
		if (pageSent)
			writer.writeEndPage();
		page = null;
	}
	
	void readTitle() {
		page.Title = new Title(bufferContents(), siteinfo.Namespaces);
	}
	
	void readId() {
		int id = Integer.parseInt(bufferContents());
		if (contrib != null)
			contrib.Id = id;
		else if (rev != null)
			rev.Id = id;
		else if (page != null)
			page.Id = id;
		else
			throw new IllegalArgumentException("Unexpected <id> outside a <page>, <revision>, or <contributor>");
	}
	
	void readRestrictions() {
		page.Restrictions = bufferContents();
	}
	
	// ------
	
	void openRevision() throws IOException {
		if (!pageSent) {
			writer.writeStartPage(page);
			pageSent = true;
		}
		
		rev = new Revision();
	}
	
	void closeRevision() throws IOException {
		writer.writeRevision(rev);
		rev = null;
	}

	void readTimestamp() {
		rev.Timestamp = parseUTCTimestamp(bufferContents());
	}

	void readComment() {
		rev.Comment = bufferContents();
	}

	void readMinor() {
		rev.Minor = true;
	}

	void readText() {
		rev.Text = bufferContents();
	}
	
	// -----------
	void openContributor() {
		contrib = null;
	}
	
	void closeContributor() {
		if (contrib == null)
			throw new IllegalArgumentException("Invalid contributor");
		
		rev.Contributor = contrib;
		contrib = null;
	}


	void readUsername() {
		contrib = new Contributor(bufferContents());
	}
	
	void readIp() {
		contrib = new Contributor(bufferContents());
	}
	
	private static final TimeZone utc = TimeZone.getTimeZone("UTC");
	private static Calendar parseUTCTimestamp(String text) {
		// 2003-10-26T04:50:47Z
		// We're doing this manually for now, though DateFormatter might work...
		String trimmed = text.trim();
		GregorianCalendar ts = new GregorianCalendar(utc);
		ts.set(
			Integer.parseInt(trimmed.substring(0,0+4)),     // year
			Integer.parseInt(trimmed.substring(5,5+2)) - 1, // month is 0-based!
			Integer.parseInt(trimmed.substring(8,8+2)),     // day
			Integer.parseInt(trimmed.substring(11,11+2)),   // hour
			Integer.parseInt(trimmed.substring(14,14+2)),   // minute
			Integer.parseInt(trimmed.substring(17,17+2)));  // second
		return ts;
	}
}
