package net.psammead.mwapi.ui;


/** a block cannot be executed */
public final class BlockAlreadySetException extends BlockException {
	/** Constructs a new exception with the specified detail message. */
	public BlockAlreadySetException(String message) {
		super(message);
	}
	
//	/** Constructs a new exception with the specified detail message and cause. */
//	public BlockAlreadySetException(String message, Throwable cause) {
//		super(message, cause);
//	}
//
//	/** Constructs a new exception with the specified cause and a detail 
//		message of (cause==null ? null : cause.toString()) (which 
//		typically contains the class and detail message of cause). */
// 	public BlockAlreadySetException(Throwable cause) {
//		super(cause);	
//	} 
}
