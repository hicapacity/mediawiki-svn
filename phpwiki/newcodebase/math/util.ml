exception FileAlreadyExists
let open_out_unless_exists path =
    if Sys.file_exists path
    then raise FileAlreadyExists
    else open_out path

let run_in_other_directory tmppath cmd =
    let prevdir = Sys.getcwd () in(
	Sys.chdir tmppath;
	let retval = Sys.command cmd in
	    (Sys.chdir prevdir; retval)
    )
