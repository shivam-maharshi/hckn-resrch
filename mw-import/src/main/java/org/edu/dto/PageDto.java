package org.edu.dto;

/**
 * DTO for Page tag in Wikipedia XML dumps.
 * 
 * @see {@link RevisionDto}
 * @author shivam.maharshi
 */
public class PageDto {

	private String title;
	private int ns;
	private int id;
	private int length;
	private RevisionDto revision;

	public String getTitle() {
		return title;
	}

	public void setTitle(String title) {
		this.title = title;
	}

	public int getNs() {
		return ns;
	}

	public void setNs(int ns) {
		this.ns = ns;
	}

	public int getId() {
		return id;
	}

	public void setId(int id) {
		this.id = id;
	}

	public RevisionDto getRevision() {
		return revision;
	}

	public void setRevision(RevisionDto revision) {
		this.revision = revision;
	}

	public int getLength() {
		return length;
	}

	public void setLength(int length) {
		this.length = length;
	}

	@Override
	public String toString() {
		return "PageDto [title=" + title + ", ns=" + ns + ", id=" + id + ", length=" + length + ", revision=" + revision
				+ "]";
	}

}
