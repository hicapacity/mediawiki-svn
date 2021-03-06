package org.mediawiki.scavenger;

import java.io.UnsupportedEncodingException;
import java.net.URLEncoder;
import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.SQLException;
import java.util.List;
import java.util.Properties;

import javax.servlet.ServletContext;
import javax.servlet.http.HttpServletRequest;

import org.mediawiki.scavenger.mysql.MyWiki;
import org.mediawiki.scavenger.oracle.OraWiki;
import org.mediawiki.scavenger.pg.PgWiki;
import org.mediawiki.scavenger.search.SearchIndex;

public abstract class Wiki {
	HttpServletRequest req;
	Properties props;
	
	protected Wiki(HttpServletRequest rq, Properties p) {
		req = rq;
		props = p;
	}
	
	public static Wiki getWiki(ServletContext ctx, HttpServletRequest req) throws Exception {
		Properties p;
		p = new Properties();
		p.load(ctx.getResourceAsStream("/WEB-INF/config.properties"));
		
		Connection dbc;
		String dbtype = p.getProperty("scavenger.dbtype");
		if (dbtype.equals("mysql")) {
			Class.forName("com.mysql.jdbc.Driver");
			dbc = DriverManager.getConnection(p.getProperty("scavenger.dburl"),
					p.getProperty("scavenger.dbuser"), p.getProperty("scavenger.dbpassword"));
			dbc.setAutoCommit(false);
			return new MyWiki(dbc, req, p);
		} else if (dbtype.equals("postgres")) {
			Class.forName("org.postgresql.Driver");
			dbc = DriverManager.getConnection(p.getProperty("scavenger.dburl"),
					p.getProperty("scavenger.dbuser"), p.getProperty("scavenger.dbpassword"));
			dbc.setAutoCommit(false);
			return new PgWiki(dbc, p.getProperty("scavenger.dbschema"), req, p);		
		} else if (dbtype.equals("oracle")) {
			Class.forName("oracle.jdbc.OracleDriver");
			dbc = DriverManager.getConnection(p.getProperty("scavenger.dburl"),
					p.getProperty("scavenger.dbuser"), p.getProperty("scavenger.dbpassword"));
			return new OraWiki(dbc, req, p);
		} else
			return null;
	}
	
	public String linkTo(String article) throws SQLException {
		Title t = getTitle(article);
		Page p = getPage(t);
		String cssclass = (p.exists() ? "wikilink" : "newlink");
		try {
			return String.format("<a class=\"%1$s\" href=\"%2$s/view/%4$s\">%3$s</a>",
					cssclass, req.getContextPath(), article,
					URLEncoder.encode(p.getTitle().getText().replaceAll(" ", "_"), "UTF-8"));
		} catch (UnsupportedEncodingException e) {
			return ""; // cannot happen
		}
	}
	
	public SearchIndex getSearchIndex() {
		String path = props.getProperty("scavenger.searchindex");
		if (path == null)
			return null;
		
		return new SearchIndex(this, path);
	}
	public abstract Title getTitle(String name);
	public abstract Page getPage(Title t) throws SQLException;
	public abstract User getUser(String name, boolean anon) throws SQLException;
	public abstract Revision getRevision(int rev_id) throws SQLException;
	public abstract void commit() throws SQLException;
	public abstract void rollback() throws SQLException;
	public abstract List<RecentChange> getRecentChanges(int num) throws SQLException;
	public abstract List<Page> getAllPages() throws SQLException;
	public abstract List<String> getPrefixMatches(String prefix, int num) throws SQLException;
	public abstract void close() throws SQLException ;
}
