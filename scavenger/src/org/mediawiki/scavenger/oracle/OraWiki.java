package org.mediawiki.scavenger.oracle;

import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.util.ArrayList;
import java.util.List;

import javax.servlet.http.HttpServletRequest;

import org.mediawiki.scavenger.Page;
import org.mediawiki.scavenger.RecentChange;
import org.mediawiki.scavenger.Revision;
import org.mediawiki.scavenger.Title;
import org.mediawiki.scavenger.User;
import org.mediawiki.scavenger.Wiki;

public class OraWiki extends Wiki {
	Connection dbc;
	
	public OraWiki(Connection d, HttpServletRequest req) throws SQLException {
		super(req);
		dbc = d;
	}
	
	public void commit() throws SQLException {
		dbc.commit();
	}

	public Title getTitle(String name) {
		return new Title(name);
	}

	public User getUser(String name, boolean anon) throws SQLException {
		return new OraUser(dbc, name, anon);
	}

	public void rollback() throws SQLException {
		dbc.rollback();
	}
	
	public OraPage getPage(Title t) throws SQLException {
		return new OraPage(dbc, t);
	}
	
	public OraRevision getRevision(int rev_id) throws SQLException {
		return new OraRevision(dbc, rev_id);
	}
	
	public static int getSerial(Connection dbc, String name) throws SQLException {
		PreparedStatement stmt = dbc.prepareStatement("SELECT " + name + ".nextval FROM dual");
		
		stmt.execute();
		ResultSet rs = stmt.getResultSet();
		if (!rs.next())
			throw new SQLException("failed to obtain id");
		int id = rs.getInt(1);
		rs.close();
		stmt.close();
		return id;
	}
	
	public List<RecentChange> getRecentChanges(int num) throws SQLException {
		List<RecentChange> result = new ArrayList<RecentChange>();
		
		PreparedStatement stmt = dbc.prepareStatement(
				"SELECT rev_id, rev_page, rev_text_id, rev_timestamp, rev_comment, " +
				"rev_user, user_name FROM revision, users WHERE user_id=rev_user " +
				"ORDER BY rev_timestamp DESC");
		stmt.execute();
		ResultSet rs = stmt.getResultSet();
		while (rs.next() && (num-- > 0)) {
			Revision r = new OraRevision(rs);
			result.add(new RecentChange(r));
		}
		rs.close();
		stmt.close();
		
		return result;
	}
	
	public List<Page> getAllPages() throws SQLException {
		List<Page> result = new ArrayList<Page>();
		
		PreparedStatement stmt = dbc.prepareStatement(
				"SELECT page_id, page_title, page_latest FROM page ORDER BY page_title ASC");
		stmt.execute();
		ResultSet rs = stmt.getResultSet();
		while (rs.next()) {
			Page p = new OraPage(dbc, rs);
			result.add(p);
		}
		
		return result;
	}
}
