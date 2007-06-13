<?php
/**
  * Based on Language.php 1.645
  * @addtogroup Language
  * Compatible to MediaWiki 1.5
  * Initial translation by Trần Thế Trung and Nguyễn Thanh Quang
  * Last update 28 August 2005 (UTC)
  */

$namespaceNames = array(
	NS_MEDIA			=> 'Phương_tiện',
	NS_SPECIAL			=> 'Đặc_biệt',
	NS_MAIN				=> '',
	NS_TALK				=> 'Thảo_luận',
	NS_USER				=> 'Thành_viên',
	NS_USER_TALK		=> 'Thảo_luận_Thành_viên',
	# NS_PROJECT set by $wgMetaNamespace
	NS_PROJECT_TALK		=> 'Thảo_luận_$1',
	NS_IMAGE			=> 'Hình',
	NS_IMAGE_TALK		=> 'Thảo_luận_Hình',
	NS_MEDIAWIKI		=> 'MediaWiki',
	NS_MEDIAWIKI_TALK	=> 'Thảo_luận_MediaWiki',
	NS_TEMPLATE			=> 'Tiêu_bản',
	NS_TEMPLATE_TALK	=> 'Thảo_luận_Tiêu_bản',
	NS_HELP				=> 'Trợ_giúp',
	NS_HELP_TALK		=> 'Thảo_luận_Trợ_giúp',
	NS_CATEGORY			=> 'Thể_loại',
	NS_CATEGORY_TALK	=> 'Thảo_luận_Thể_loại'
);

$skinNames = array(
	'standard'		=> 'Cổ điển',
	'nostalgia'		=> 'Vọng cổ',
	'myskin'		=> 'Cá nhân'
);

$magicWords = array(
	'redirect'               => array( 0,    '#redirect' , '#đổi'             ),
	'notoc'                  => array( 0,    '__NOTOC__' , '__KHÔNGMỤCMỤC__'             ),
	'forcetoc'               => array( 0,    '__FORCETOC__', '__LUÔNMỤCLỤC__'        ),
	'toc'                    => array( 0,    '__TOC__' , '__MỤCLỤC__'               ),
	'noeditsection'          => array( 0,    '__NOEDITSECTION__', '__KHÔNGSỬAMỤC__'      ),
	'start'                  => array( 0,    '__START__' , '__BẮTĐẦU__'             ),
	'currentmonth'           => array( 1,    'CURRENTMONTH' , 'THÁNGNÀY'          ),
	'currentmonthname'       => array( 1,    'CURRENTMONTHNAME'  , 'TÊNTHÁNGNÀY'     ),
	'currentmonthnamegen'    => array( 1,    'CURRENTMONTHNAMEGEN' , 'TÊNDÀITHÁNGNÀY'   ),
	'currentmonthabbrev'     => array( 1,    'CURRENTMONTHABBREV'  , 'TÊNNGẮNTHÁNGNÀY'  ),
	'currentday'             => array( 1,    'CURRENTDAY'       , 'NGÀYNÀY'     ),
	'currentdayname'         => array( 1,    'CURRENTDAYNAME'   , 'TÊNNGÀYNÀY'      ),
	'currentyear'            => array( 1,    'CURRENTYEAR'    , 'NĂMNÀY'        ),
	'currenttime'            => array( 1,    'CURRENTTIME'     , 'GIỜNÀY'       ),
	'numberofarticles'       => array( 1,    'NUMBEROFARTICLES'  , 'SỐBÀI'     ),
	'numberoffiles'          => array( 1,    'NUMBEROFFILES'   , 'SỐTẬPTIN'       ),
	'pagename'               => array( 1,    'PAGENAME'      , 'TÊNTRANG'        ),
	'pagenamee'              => array( 1,    'PAGENAMEE'   , 'TÊNTRANG2'           ),
	'namespace'              => array( 1,    'NAMESPACE'   , 'KHÔNGGIANTÊN'           ),
	'msg'                    => array( 0,    'MSG:'     , 'NHẮN:'              ),
	'subst'                  => array( 0,    'SUBST:'   ,  'THẾ:'            ),
	'msgnw'                  => array( 0,    'MSGNW:'    ,  'NHẮNMỚI:'             ),
	'img_thumbnail'          => array( 1,    'thumbnail', 'thumb' , 'nhỏ'    ),
	'img_right'              => array( 1,    'right' , 'phải'                 ),
	'img_left'               => array( 1,    'left'  , 'trái'                ),
	'img_none'               => array( 1,    'none'  , 'không'                 ),
	'img_width'              => array( 1,    '$1px'                   ),
	'img_center'             => array( 1,    'center', 'centre' , 'giữa'      ),
	'img_framed'             => array( 1,    'framed', 'enframed', 'frame' , 'khung'),
	'int'                    => array( 0,    'INT:'                   ),
	'sitename'               => array( 1,    'SITENAME'  , 'TÊNMẠNG'             ),
	'ns'                     => array( 0,    'NS:'                    ),
	'localurl'               => array( 0,    'LOCALURL:'              ),
	'localurle'              => array( 0,    'LOCALURLE:'             ),
	'server'                 => array( 0,    'SERVER'    , 'MÁYCHỦ'             ),
	'servername'             => array( 0,    'SERVERNAME' , 'TÊNMÁYCHỦ'            ),
	'scriptpath'             => array( 0,    'SCRIPTPATH'  , ''           ),
	'grammar'                => array( 0,    'GRAMMAR:'   , 'NGỮPHÁP'            ),
	'notitleconvert'         => array( 0,    '__NOTITLECONVERT__',
'__NOTC__', '__KHÔNGCHUYỂNTÊN__'),
	'nocontentconvert'       => array( 0,    '__NOCONTENTCONVERT__',
'__NOCC__', '__KHÔNGCHUYỂNNỘIDUNG__'),
	'currentweek'            => array( 1,    'CURRENTWEEK' , 'TUẦNNÀY'           ),
	'currentdow'             => array( 1,    'CURRENTDOW'             ),
	'revisionid'             => array( 1,    'REVISIONID'  , 'SỐBẢN'           ),
 );

$datePreferences = array(
	'default',
	'vi normal',
	'vi spelloutmonth',
	'vi shortcolon',
	'vi shorth',
	'ISO 8601',
);

$defaultDateFormat = 'vi normal';

$dateFormats = array(
	'vi normal time' => 'H:i',
	'vi normal date' => '"ngày" j "tháng" n "năm" Y',
	'vi normal both' => 'H:i, "ngày" j "tháng" n "năm" Y',

	'vi spelloutmonth time' => 'H:i',
	'vi spelloutmonth date' => '"ngày" j xg "năm" Y',
	'vi spelloutmonth both' => 'H:i, "ngày" j xg "năm" Y',

	'vi shortcolon time' => 'H:i',
	'vi shortcolon date' => 'j/n/Y',
	'vi shortcolon both' => 'H:i, j/n/Y',

	'vi shorth time' => 'H"h"i',
	'vi shorth date' => 'j/n/Y',
	'vi shorth both' => 'H"h"i, j/n/Y',
);

$datePreferenceMigrationMap = array(
	'default',
	'vi normal',
	'vi normal',
	'vi normal',
);


$linkTrail = "/^([a-zàâçéèêîôûäëïöüùÇÉÂÊÎÔÛÄËÏÖÜÀÈÙ]+)(.*)$/sDu";
$separatorTransformTable = array(',' => '.', '.' => ',' );


$messages = array(
# User preference toggles
'tog-underline'               => 'Gạch chân liên kết',
'tog-highlightbroken'         => 'Liên kết đến trang chưa có <a href="" class="new">như này</a> (nếu không thì <a href="" class="internal">như này</a>).',
'tog-justify'                 => 'Căn đều hai bên đoạn văn',
'tog-hideminor'               => 'Giấu <i>thay đổi</i> nhỏ',
'tog-usenewrc'                => 'Thay đổi gần đây nhiều chức năng (JavaScript)',
'tog-numberheadings'          => 'Đánh số tự động các đề mục',
'tog-showtoolbar'             => 'Hiển thị thanh soạn thảo (JavaScript)',
'tog-editondblclick'          => 'Nhấn đúp để soạn thảo trang (JavaScript)',
'tog-editsection'             => 'Bấm liên kết [sửa] để soạn bài',
'tog-editsectiononrightclick' => 'Bấm góc phải cạnh đề mục để soạn mục này (JavaScript)',
'tog-showtoc'                 => 'Hiển thị mục lục (cho bài có trên 3 đề mục)',
'tog-rememberpassword'        => 'Nhớ mật khẩu của tôi (cookie)',
'tog-editwidth'               => 'Cửa sổ soạn thảo mở rộng',
'tog-watchdefault'            => 'Tự động theo dõi bài tôi viết hoặc sửa',
'tog-minordefault'            => 'Các soạn thảo của tôi được mặc định là thay đổi nhỏ',
'tog-previewontop'            => 'Phần xem thử nằm trên hộp soạn thảo',
'tog-previewonfirst'          => 'Luôn xem thử trước khi lưu soạn thảo',
'tog-nocache'                 => 'Không lưu trang trong bộ nhớ đệm',
'tog-enotifwatchlistpages'    => 'Gửi tôi thông báo về thay đổi của trang',
'tog-enotifusertalkpages'     => 'Gửi tôi thông báo khi trang thảo luận với tôi thay đổi',
'tog-enotifminoredits'        => 'Gửi thông báo cho tôi về cả sửa đổi nhỏ',
'tog-enotifrevealaddr'        => 'Thể hiện địa chỉ thư của tôi trong thư thông báo',
'tog-shownumberswatching'     => 'Xem số người xem',
'tog-fancysig'                => 'Chữ ký không có liên kết đến trang cá nhân',
'tog-externaleditor'          => 'Mặc định dùng soạn thảo bên ngoài',
'tog-externaldiff'            => 'Mặc định dùng so sánh bên ngoài',

'underline-always'  => 'Luôn',
'underline-never'   => 'Không bao giờ',
'underline-default' => 'Mặc định của trình duyệt',

# Dates
'sunday'        => 'chủ nhật',
'monday'        => 'thứ hai',
'tuesday'       => 'thứ ba',
'wednesday'     => 'thứ tư',
'thursday'      => 'thứ năm',
'friday'        => 'thứ sáu',
'saturday'      => 'thứ bảy',
'sun'           => 'chủ nhật',
'mon'           => 'thứ 2',
'tue'           => 'thứ 3',
'wed'           => 'thứ 4',
'thu'           => 'thứ 5',
'fri'           => 'thứ 6',
'sat'           => 'thứ 7',
'january'       => 'tháng 1',
'february'      => 'tháng 2',
'march'         => 'tháng 3',
'april'         => 'tháng 4',
'may_long'      => 'tháng 5',
'june'          => 'tháng 6',
'july'          => 'tháng 7',
'august'        => 'tháng 8',
'september'     => 'tháng 9',
'october'       => 'tháng 10',
'november'      => 'tháng 11',
'december'      => 'tháng 12',
'january-gen'   => 'tháng Một',
'february-gen'  => 'tháng Hai',
'march-gen'     => 'tháng Ba',
'april-gen'     => 'tháng Tư',
'may-gen'       => 'tháng Năm',
'june-gen'      => 'tháng Sáu',
'july-gen'      => 'tháng Bảy',
'august-gen'    => 'tháng Tám',
'september-gen' => 'tháng Chín',
'october-gen'   => 'tháng Mười',
'november-gen'  => 'tháng Mười một',
'december-gen'  => 'tháng Mười hai',
'jan'           => 'tháng 1',
'feb'           => 'tháng 2',
'mar'           => 'tháng 3',
'apr'           => 'tháng 4',
'may'           => 'tháng 5',
'jun'           => 'tháng 6',
'jul'           => 'tháng 7',
'aug'           => 'tháng 8',
'sep'           => 'tháng 9',
'oct'           => 'tháng 10',
'nov'           => 'tháng 11',
'dec'           => 'tháng 12',

# Bits of text used by many pages
'categories'      => 'Thể loại',
'pagecategories'  => 'Thể loại',
'category_header' => 'Các bài trong Thể loại "$1"',
'subcategories'   => 'Tiểu thể loại',

'mainpagetext'      => 'Phần mềm {{SITENAME}} đã cài đặt.',
'mainpagedocfooter' => 'Xin đọc [http://meta.wikimedia.org/wiki/MediaWiki_i18n tài liệu hướng dẫn cách tùy biến giao diện] và [http://meta.wikimedia.org/wiki/MediaWiki_User%27s_Guide Cẩm nang sử dụng] (bằng tiếng Anh) để biết cách dùng và thiết lập thông số.',

'about'          => 'Giới thiệu',
'article'        => 'Bài',
'newwindow'      => '(mở cửa sổ mới)',
'cancel'         => 'Bỏ',
'qbfind'         => 'Tìm kiếm',
'qbbrowse'       => 'Dẫn lái',
'qbedit'         => 'Sửa',
'qbpageoptions'  => 'Lựa chọn',
'qbpageinfo'     => 'Thông tin',
'qbmyoptions'    => 'Lựa chọn của tôi',
'qbspecialpages' => 'Trang đặc biệt',
'moredotdotdot'  => 'Thêm nữa...',
'mypage'         => 'Trang của tôi',
'mytalk'         => 'Thảo luận với tôi',
'anontalk'       => 'Thảo luận với IP này',
'navigation'     => 'Dẫn lái',

'errorpagetitle'    => 'Lỗi',
'returnto'          => 'Quay lại $1.',
'tagline'           => 'Bài từ dự án mở {{SITENAME}}.',
'help'              => 'Trợ giúp',
'search'            => 'Tìm kiếm',
'searchbutton'      => 'Tìm kiếm',
'go'                => 'Xem',
'searcharticle'     => 'Xem',
'history'           => 'Lịch sử trang',
'history_short'     => 'Lịch sử',
'info_short'        => 'Thông tin',
'printableversion'  => 'Bản để in',
'permalink'         => 'Liên kết thường trực',
'print'             => 'In',
'edit'              => 'Sửa',
'editthispage'      => 'Sửa trang này',
'delete'            => 'Xóa',
'deletethispage'    => 'Xóa trang này',
'undelete_short'    => 'Phục hồi',
'protect'           => 'Khóa',
'protectthispage'   => 'Khóa trang này',
'unprotect'         => 'Mở',
'unprotectthispage' => 'Mở trang này',
'newpage'           => 'Trang mới',
'talkpage'          => 'Trang thảo luận',
'specialpage'       => 'Trang đặc biệt',
'personaltools'     => 'Công cụ cá nhân',
'postcomment'       => 'Thêm bàn luận',
'articlepage'       => 'Xem bài',
'talk'              => 'Thảo luận',
'views'             => 'Xem',
'toolbox'           => 'Công cụ',
'userpage'          => 'Trang thành viên',
'projectpage'       => 'Trang Wikipedia',
'imagepage'         => 'Trang hình',
'viewtalkpage'      => 'Trang thảo luận',
'otherlanguages'    => 'Ngôn ngữ khác',
'redirectedfrom'    => '(đổi hướng từ $1)',
'lastmodifiedat'    => 'Lần sửa cuối : $2, $1.', # $1 date, $2 time
'viewcount'         => 'Trang này đã được đọc $1 lần.',
'protectedpage'     => 'Trang bị khóa',

# All link text and link target definitions of links into project namespace that get used by other message strings, with the exception of user group pages (see grouppage) and the disambiguation template definition (see disambiguations).
'aboutsite'         => 'Giới thiệu {{SITENAME}}',
'aboutpage'         => '{{ns:4}}:Giới_thiệu',
'bugreports'        => 'Báo lỗi',
'bugreportspage'    => '{{ns:4}}:Báo lỗi',
'copyright'         => 'Bản quyền $1.',
'copyrightpagename' => 'giấy phép {{SITENAME}}',
'copyrightpage'     => '{{ns:4}}:Bản quyền',
'currentevents'     => 'Thời sự',
'currentevents-url' => 'Thời_sự',
'disclaimers'       => 'Cảnh báo',
'disclaimerpage'    => '{{ns:4}}:Cảnh báo chung',
'edithelp'          => 'Trợ giúp',
'edithelppage'      => 'Trợ_giúp:Soạn thảo',
'faq'               => 'FAQ',
'faqpage'           => '{{ns:4}}:FAQ',
'helppage'          => '{{ns:4}}:Trợ giúp',
'mainpage'          => 'Trang đầu',
'portal'            => 'Cộng đồng',
'portal-url'        => '{{ns:4}}:Cộng_đồng',
'sitesupport'       => 'Quyên góp',
'sitesupport-url'   => '{{ns:4}}:Quyên_góp',

'badaccess' => 'Lỗi truy cập',

'versionrequired'     => 'Cần phiên bản $1 của MediaWiki',
'versionrequiredtext' => 'Cần phiên bản $1 của MediaWiki để xem trang này. Xem [[Đặc_biệt:Phiên_bản]]',

'ok'              => 'OK',
'pagetitle'       => '$1 - {{SITENAME}}',
'retrievedfrom'   => 'Lấy từ « $1 »',
'newmessageslink' => 'tin nhắn mới',
'editsection'     => 'Sửa',
'editold'         => 'Sửa',
'toc'             => 'Mục lục',
'showtoc'         => 'xem',
'hidetoc'         => 'giấu',
'thisisdeleted'   => 'Xem hay phục hồi $1 ?',
'restorelink'     => 'Phục hồi 1 sửa đổi',
'feedlinks'       => 'Nạp:',

# Short words for each namespace, by default used in the 'article' tab in monobook
'nstab-main'      => 'Bài',
'nstab-user'      => 'Trang thành viên',
'nstab-media'     => 'Phương tiện',
'nstab-special'   => 'Đặc biệt',
'nstab-project'   => 'Giới thiệu',
'nstab-image'     => 'Hình',
'nstab-mediawiki' => 'Tin nhắn',
'nstab-template'  => 'Tiêu bản',
'nstab-help'      => 'Trợ giúp',
'nstab-category'  => 'Thể loại',

# Main script and global functions
'nosuchaction'      => 'Không hiểu',
'nosuchactiontext'  => 'Phần mềm không hiểu bạn muốn làm gì.',
'nosuchspecialpage' => 'Không tìm thấy',
'nospecialpagetext' => 'Không có trang đặc biệt này.',

# General errors
'error'                => 'Lỗi',
'databaseerror'        => 'Lỗi cơ sở dữ liệu',
'dberrortext'          => 'Lỗi cú pháp trong cơ sở dữ liệu. Truy vấn vừa rồi là:
<blockquote><tt>$1</tt></blockquote>
từ hàm "<tt>$2</tt>".
MySQL báo lỗi "<tt>$3: $4</tt>".',
'dberrortextcl'        => 'Một truy vấn cơ sở dữ liệu có lỗi cú pháp.  Truy vấn vừa rồi là:
"$1"
thực hiện bởi hàm "$2"
MySQL báo lỗi "$3 : $4".',
'noconnect'            => 'Hiện tại không kết nối với cơ sở dữ liệu được.',
'nodb'                 => 'Không thấy cơ sở dữ liệu $1',
'cachederror'          => 'Đây là bản sao của trang bạn yêu cầu, có thể không cập nhật.',
'laggedslavemode'      => 'Chú ý : trang có thể chưa được cập nhật phiên bản cuối.',
'readonly'             => 'Cơ sở dữ liệu bị khóa',
'enterlockreason'      => 'Nêu lý do khóa, thời gian khóa',
'readonlytext'         => 'Cơ sở dữ liệu {{SITENAME}} hiện bị khóa, có thể để bảo trì, sau đó sẽ trở lại bìn thường. Lý do khóa :
<p>$1',
'missingarticle'       => 'Cơ sở dữ liệu không thấy trang "$1".
Đây không phải lỗi cơ sở dữ liệu, mà có thể là lỗi phần mềm.
Xin báo lỗi này cho người quản lý, nói rõ tên trang bị lỗi.',
'readonly_lag'         => 'Cơ sở dữ liệu bị khóa để các máy chủ cập nhật thông tin của nhau.',
'internalerror'        => 'Lỗi nội bộ',
'filecopyerror'        => 'Không sao chép « $1 » đến « $2 » được.',
'filerenameerror'      => 'Không đổi tên « $1 » đến « $2 » được.',
'filedeleteerror'      => 'Không xóa « $1 » được.',
'filenotfound'         => 'Không thấy "$1".',
'unexpected'           => 'Chưa ngờ tới : "$1"="$2".',
'formerror'            => 'Lỗi: không gửi đơn đi được.',
'badarticleerror'      => 'Không thực hiện được hành động như vậy trên trang này.',
'cannotdelete'         => 'Không xóa trang được.',
'badtitle'             => 'Đề mục sai',
'badtitletext'         => 'Đề mục sai, rỗng hay liên kết liên ngôn ngữ sai.',
'perfdisabled'         => 'Chức năng này bị khóa vì nó làm chậm cơ sở dữ liệu.',
'perfcached'           => 'Dữ liệu sau lấy từ bộ nhớ đệm và có thể không cập nhật:',
'wrong_wfQuery_params' => 'Tham số sai trong wfQuery()<br />
Hàm : $1<br />
Truy vấn : $2',
'viewsource'           => 'Xem mã nguồn',
'sqlhidden'            => '(giấu truy vấn sql)',

# Login and logout pages
'logouttitle'                => 'Đăng xuất',
'logouttext'                 => 'Bạn đã đang xuất.
Bạn vẫn dùng {{SITENAME}} được như người vô danh, hoặc đăng nhập lại, có thể dưới tài khoản khác.',
'welcomecreation'            => '<h2>Chào mừng, $1!</h2><p>Tài khoản của bạn đã mở. Mời bạn vào trang Lựa chọn cá nhân dành cho bạn.',
'loginpagetitle'             => 'Đăng nhập',
'yourname'                   => 'Tên',
'yourpassword'               => 'Mật khẩu',
'yourpasswordagain'          => 'Vào lại mật khẩu',
'remembermypassword'         => 'Nhớ mật khẩu (cookie)',
'yourdomainname'             => 'Tên miền của bạn',
'externaldberror'            => 'Có thể có lỗi cơ sở dữ liệu hoặc bạn không thể cập nhật tài khoản bên ngoài.',
'loginproblem'               => '<b>Trục trặc đăng nhập.</b><br />Mời thử lại!',
'alreadyloggedin'            => "'''$1, bạn đã đăng nhập rồi!'''<br />",
'login'                      => 'Đăng nhập',
'loginprompt'                => 'Bạn cần bật cookie để đăng nhập vào {{SITENAME}}.',
'userlogin'                  => 'Mở tài khoản hay đăng nhập',
'logout'                     => 'Đăng xuất',
'userlogout'                 => 'Đăng xuất',
'notloggedin'                => 'Chưa đăng nhập',
'createaccount'              => 'Mở tài khoản',
'createaccountmail'          => 'qua thư điện tử',
'badretype'                  => '2 mật khẩu không khớp.',
'userexists'                 => 'Tên thành viên đã có người lấy. Xin chọn tên khác.',
'youremail'                  => 'Thư điện tử *',
'yourrealname'               => 'Tên thật *',
'yourlanguage'               => 'Ngôn ngữ&nbsp;',
'yourvariant'                => 'Ngôn ngữ địa phương',
'yournick'                   => 'Chữ ký trong thảo luận (dùng ~~~)',
'prefs-help-realname'        => '* <strong>Tên thật</strong> (tùy): tên này (nếu được nhập) sẽ được dùng trong các đóng góp của bạn.',
'loginerror'                 => 'Lỗi đăng nhập',
'prefs-help-email'           => '* <strong>Thư điện tử</strong> (tùy): người khác có thể gửi thư từ trang này cho bạn mà họ vẫn không biết địa chỉ thư của bạn; địa chỉ thư còn giúp gửi bạn mật khẩu nếu bạn quên.',
'nocookiesnew'               => 'Tài khoản đã mở, nhưng bạn chưa được đăng nhập. Xin bật cookies và đăng nhập lại.',
'nocookieslogin'             => ' Xin bật cookies và đăng nhập lại.',
'noname'                     => 'Chưa nhập tên.',
'loginsuccesstitle'          => 'Đăng nhập thành công.',
'loginsuccess'               => 'Bạn đã đăng nhập vào {{SITENAME}} với tên
"$1".',
'nosuchuser'                 => 'Thành viên "$1" không tồn tại. Xin kiểm tra lại tên, hoặc mở tài khoản mới.',
'nosuchusershort'            => 'Không có « $1 ». Xin kiểm tra lại.',
'wrongpassword'              => 'Mật khẩu sai, xin nhập lại.',
'mailmypassword'             => 'Gửi tôi mật khẩu',
'passwordremindertitle'      => 'Mật khẩu {{SITENAME}}',
'passwordremindertext'       => 'Ai đó (có thể là bạn) có địa chỉ IP $1 đã xin gửi mật khẩu mới tới thư điện tử của bạn. Mật khẩu mới của "$2" là "$3". Bạn nên đăng nhập và thay đổi mật khẩu này.',
'noemail'                    => 'Thành viên "$1" không có thư điện tử.',
'passwordsent'               => 'Mật khẩu mới đã được gửi tới thư điện tử của thành viên "$1". Xin đăng nhập ngay khi nhận được.',
'eauthentsent'               => 'Thư xác nhận đã được gửi. Trước khi dùng chức năng nhận thư, bạn cần thực hiện hướng dẫn trong thư xác nhận, để đảm bảo tài khoản thuộc về bạn.',
'mailerror'                  => 'Lỗi gửi thư : $1',
'acct_creation_throttle_hit' => 'Bạn đã mở $1 tài khoản. Không thể mở thêm được nữa.',
'emailauthenticated'         => 'Địa chỉ thư điện tử của bạn được xác nhận tại $1.',
'emailnotauthenticated'      => 'Địa chỉ thư điện tử của bạn chưa được xác nhận. Chức năng thư điện tử chưa bật.',
'noemailprefs'               => '<strong>Không có địa chỉ thư điện tử</strong>, chức năng sau có thể không hoạt động.',
'emailconfirmlink'           => 'Xác nhận địa chỉ thư điện tử',
'invalidemailaddress'        => 'Địa chỉ thư điện tử có vẻ sai. Xin nhập lại.',

# Edit page toolbar
'bold_sample'     => 'Chữ đậm',
'bold_tip'        => 'Chữ đậm',
'italic_sample'   => 'Chữ xiên',
'italic_tip'      => 'Chữ xiên',
'link_sample'     => 'Liên kết',
'link_tip'        => 'Liên kết',
'extlink_sample'  => 'http://www.vidu.com liên kết ngoài',
'extlink_tip'     => 'Liên kết ngoài (nhớ http://)',
'headline_sample' => 'Đề mục',
'headline_tip'    => 'Đề mục cấp 2',
'math_sample'     => 'Nhập công thức toán vào đây',
'math_tip'        => 'Công thức toán (LaTeX)',
'nowiki_sample'   => 'Nhập dòng chữ không theo định dạng wiki vào đây',
'nowiki_tip'      => 'Không theo định dạng wiki',
'image_sample'    => 'Ví dụ.jpg',
'image_tip'       => 'Chèn hình',
'media_sample'    => 'Ví dụ.ogg',
'media_tip'       => 'Liên kết phương tiện',
'sig_tip'         => 'Ký tên có ngày',
'hr_tip'          => 'Dòng kẻ ngang (không nên lạm dụng)',

# Edit pages
'summary'                => 'Tóm tắt&nbsp;',
'subject'                => 'Đề mục',
'minoredit'              => 'Sửa đổi nhỏ',
'watchthis'              => 'Theo dõi bài này',
'savearticle'            => 'Lưu',
'preview'                => 'Xem thử',
'showpreview'            => 'Xem thử',
'showdiff'               => 'Xem thay đổi',
'blockedtitle'           => 'Thành viên bị chặn',
'blockedtext'            => 'Bạn bị chặn bởi $1 vì:<br />$2<p>Bạn có thể liên hệ với $1 hoặc các [[{{ns:4}}:Người quản lý|người quản lý]] khác để thảo luận.',
'whitelistedittitle'     => 'Cần đăng nhập để sửa bài',
'whitelistedittext'      => 'Bạn cần [[Đặc_biệt:Userlogin|đăng nhập]] để viết bài.',
'whitelistreadtitle'     => 'Cần đăng nhập để đọc bài',
'whitelistreadtext'      => 'Bạn cần [[Đặc_biệt:Userlogin|đăng nhập]] để đọc bài.',
'whitelistacctitle'      => 'Bạn không được phép mở tài khoản.',
'whitelistacctext'       => 'Bạn cần [[Đặc_biệt:Userlogin|đăng nhập]] để mở tài khoản.',
'loginreqtitle'          => 'Cần nhập tên',
'accmailtitle'           => 'Đã gửi mật khẩu.',
'accmailtext'            => 'Mật khẩu của « $1 » đã được gửi đến $2.',
'newarticle'             => '(mới)',
'newarticletext'         => 'Nhập nội dung bài viết vào đây.',
'anontalkpagetext'       => "---- ''Đây là trang thảo luận của một người vô danh (chưa mở tài khoản hoặc không dùng tài khoản). Chúng ta chỉ có thể dùng [[địa chỉ IP]] để liên hệ. Nhiều thành viên có thể có chung địa chỉ này. Nếu bạn, một thành viên vô danh, nhận được tin nhắn không liên quan đến bạn, bạn có thể [[Đặc_biệt:Userlogin|mở tài khoản]] để tránh nhầm lẫn này.",
'noarticletext'          => '(Trang này hiện chưa có gì)',
'clearyourcache'         => "'''Chú ý:''' Sau khi lưu, bạn cần tái truy cập để xem sự thay đổi : Mozilla / Konqueror : ctrl-r, Firefox / IE / Opera : ctrl-f5, Safari : cmd-r.",
'usercssjsyoucanpreview' => "'''Chú ý :''' xem thử trước để kiểm tra trang css/js mới trước khi lưu.",
'usercsspreview'         => "'''Bạn đang xem thử trang css và nó chưa được lưu !'''",
'userjspreview'          => "'''Bạn đang xem thử trang Javascript và nó chưa được lưu !'''",
'updated'                => '(Cập nhật)',
'note'                   => '<strong>Chú ý :</strong>',
'previewnote'            => 'Chú ý, đây chỉ là thử nghiệm, chưa lưu!',
'previewconflict'        => 'Trang này có vẻ như đã được lưu bởi người khác sau khi bạn bắt đầu sửa.',
'editing'                => 'Soạn thảo $1',
'editinguser'            => 'Soạn thảo $1',
'editingsection'         => 'Soạn thảo $1',
'editingcomment'         => 'Soạn thảo $1',
'editconflict'           => 'Sửa đổi mâu thuẫn : $1',
'explainconflict'        => '<b>Trang này có đã được lưu bởi người khác sau khi bạn bắt đầu sửa. Phía trên là bản vừa được lưu. Phía dưới là sửa đổi của bạn. Bạn phải sửa lại từ bản đã lưu.</b><br />',
'yourtext'               => 'Nội dung bạn nhập',
'storedversion'          => 'Phiên bản lưu',
'nonunicodebrowser'      => '<strong>CHU Y: Trinh duyet cua ban khong ho tro Unicode, xin sua lai truoc khi viet bai.</strong><strong>WARNING: Your browser is not unicode compliant, please change it before editing an article.</strong>',
'editingold'             => '<strong>Chú ý: bạn đang sửa một phiên bản cũ. Nếu bạn lưu, các sửa đổi trên phiên bản mới hơn sẽ mất.</strong>',
'yourdiff'               => 'Khác',
'copyrightwarning2'      => '*Xin dùng [[{{ns:4}}:Chỗ thử|chỗ thử soạn thảo]] nếu bạn chỉ muốn thử nghiệm.
*Xin đọc thêm hướng dẫn về [[Trợ giúp:Soạn thảo|soạn thảo]] và [[Trợ giúp:Viết bài mới|viết bài mới]].
*Mọi đóng góp cho {{SITENAME}} đều tuân theo GNU Free Documentation Licence (Xem $1). Nếu bạn không muốn nội dung bạn nhập bị người khác sửa, đừng viết vào đây. <br /><b>KHÔNG LẤY TÀI LIỆU TỪ NGUỒN KHÁC MÀ CHƯA XIN PHÉP!</b>',
'longpagewarning'        => '<strong>Chú ý : Trang này dài $1 kb; nhiều trình duyệt không tải được trang dài hơn 32 kb. Bạn nên chia nhỏ trang này thành nhiều trang.</strong>',
'readonlywarning'        => '<strong>Chú ý : trang này bị khóa để bảo trì. Bạn chỉ có thể sao nội dung để sửa đổi trên máy cá nhân.</strong>',
'protectedpagewarning'   => '<strong>Chú ý : trang này bị khóa. Chỉ có quản lý viên mới sửa được. Chú ý tuân thủ [[{{ns:4}}:Trang_bị_khóa|quy định về trang bị khóa]].</strong>',
'templatesused'          => 'Các tiêu bản dùng trong trang này',

# History pages
'revhistory'          => 'Bản cũ',
'nohistory'           => 'Trang này chưa có lịch sử.',
'revnotfound'         => 'Không thấy',
'revnotfoundtext'     => 'Không thấy phiên bản trước của trang này. Xin kiểm tra lại.',
'loadhist'            => 'Đang mở lịch sử...',
'currentrev'          => 'Hiện nay',
'revisionasof'        => '$1',
'previousrevision'    => '&larr; Bản trước',
'nextrevision'        => 'Bản sau &rarr;',
'currentrevisionlink' => 'xem bản hiện nay',
'cur'                 => 'nay',
'next'                => 'sau',
'last'                => 'cũ',
'orig'                => 'gốc',
'histlegend'          => 'Chú thích : (nay) = so sánh với bản hiện nay,
(cũ) = so sánh với bản trước, n = sửa nhỏ',
'deletedrev'          => '[đã xóa]',
'histfirst'           => 'cũ nhất',
'histlast'            => 'mới nhất',

# Diffs
'difference'                => '(Khác biệt giữa các bản)',
'loadingrev'                => 'đang lấy các bản để so sánh',
'lineno'                    => 'Dòng $1:',
'editcurrent'               => 'Sửa bản hiện nay',
'selectnewerversionfordiff' => 'Chọn bản mới hơn',
'selectolderversionfordiff' => 'Chọn bản cũ hơn',
'compareselectedversions'   => 'So sánh các bản đã chọn',

# Search results
'searchresults'         => 'Kết quả tìm',
'searchresulttext'      => 'Xem thêm [[{{ns:4}}:Tìm_kiếm|hướng dẫn tìm kiếm {{SITENAME}}]].',
'searchsubtitle'        => 'Cho truy vấn "[[:$1]]"',
'searchsubtitleinvalid' => 'Cho truy vấn "$1"',
'badquery'              => 'Truy vấn sai',
'badquerytext'          => 'Truy vấn sai: ngắn hơn 3 chữ cái, hoặc sai chính tả ví dụ như "mèo và và chuột". Xin mời thử lại.',
'matchtotals'           => 'Truy vấn "$1" phù hợp với $2 tên bài và câu chữ trong $3 bài.',
'noexactmatch'          => 'Không có trang tên như này, xin thử công cụ tìm.',
'titlematches'          => 'Đề mục tương tự',
'notitlematches'        => 'Không có tên bài nào có nội dung tương tự',
'textmatches'           => 'Câu chữ tương tự',
'notextmatches'         => 'Không có câu chữ nào trong các bài có nội dung tương tự',
'prevn'                 => '$1 trước',
'nextn'                 => '$1 sau',
'viewprevnext'          => 'Xem ($1) ($2) ($3).',
'showingresults'        => 'Xem <b>$1</b> kết quả bắt đầu từ #<b>$2</b>.',
'showingresultsnum'     => 'Xem <b>$3</b> kết quả bắt đầu từ #<b>$2</b>.',
'nonefound'             => '<strong>Chú ý</strong>: viết truy vấn tìm kiếm dài quá có thể gây khó khăn khi tìm.',
'powersearch'           => 'Tìm',
'powersearchtext'       => '
Tìm trong :<br />
$1<br />
$2 gồm cả trang đổi hướng &nbsp; Tìm $3 $9',
'searchdisabled'        => '<p>Công cụ tìm kiếm hiện bị khóa. Chức năng này sẽ được mở lại khi có điều kiện lắp thêm máy chủ. Hiện tại có thể tìm với Google:</p>',
'blanknamespace'        => '(Chính)',

# Preferences page
'preferences'             => 'Lựa chọn cá nhân',
'prefsnologin'            => 'Chưa đăng nhập',
'prefsnologintext'        => 'Bạn phải [[Đặc_biệt:Userlogin|đăng nhập]] để sửa các Lựa chọn cá nhân của bạn.',
'prefsreset'              => 'Các Lựa chọn cá nhân đã được mặc định lại.',
'qbsettings'              => 'Các lựa chọn cho thanh công cụ',
'qbsettings-none'         => 'Không',
'qbsettings-fixedleft'    => 'Trái',
'qbsettings-fixedright'   => 'Phải',
'qbsettings-floatingleft' => 'Nổi bên trái',
'changepassword'          => 'Đổi mật khẩu',
'skin'                    => 'Ngoại hình',
'math'                    => 'Công thức toán',
'dateformat'              => 'Ngày tháng',
'datedefault'             => 'Không lựa chọn',
'math_failure'            => 'Lỗi toán',
'math_unknown_error'      => 'lỗi chưa rõ',
'math_unknown_function'   => 'hàm chưa rõ',
'math_lexing_error'       => 'lỗi chính tả',
'math_syntax_error'       => 'lỗi ngữ pháp',
'math_image_error'        => 'Không chuyển sang định dạng PNG được, xin kiểm tra lại cài đặt Latex, dvips, gs và convert',
'math_bad_tmpdir'         => 'Không tạo mới hay viết vào thư mục tạm thời được',
'math_bad_output'         => 'Không tạo mới hay viết vào thư mục kết quả được',
'math_notexvc'            => "Không thấy 'texvc'. Xem math/README để cài đặt lại.",
'prefs-personal'          => 'Thông tin cá nhân',
'prefs-rc'                => 'Thay đổi gần đây',
'prefs-misc'              => 'Lựa chọn khác',
'saveprefs'               => 'Lưu lựa chọn',
'resetprefs'              => 'Mặc định lại lựa chọn',
'oldpassword'             => 'Mật khẩu cũ',
'newpassword'             => 'Mật khẩu mới&nbsp;',
'retypenew'               => 'Gõ lại',
'textboxsize'             => 'Kích thước cửa sổ soạn thảo',
'rows'                    => 'Hàng&nbsp;',
'columns'                 => 'Cột',
'searchresultshead'       => 'Xem kết quả tìm kiếm',
'resultsperpage'          => 'Số kết quả trong một trang&nbsp;',
'contextlines'            => 'Số hàng trong một kết quả',
'contextchars'            => 'Số chữ trong một hàng',
'recentchangescount'      => 'Số đề mục trong Thay đổi gần đây',
'savedprefs'              => 'Đã lưu các lựa chọn cá nhân.',
'timezonelegend'          => 'Múi giờ',
'timezonetext'            => 'Nếu không chọn, giờ mặc định UTC sẽ được dùng.',
'localtime'               => 'Giờ địa phương',
'timezoneoffset'          => 'Chênh giờ¹',
'servertime'              => 'Giờ máy chủ',
'guesstimezone'           => 'Dùng giờ của trình duyệt',
'defaultns'               => 'Mặc định tìm kiếm trong không gian tên :',
'default'                 => 'mặc định',
'files'                   => 'Tệp tin',

# User rights
'userrights-lookup-user'     => 'Quản lý nhóm thành viên',
'userrights-user-editname'   => 'Nhập tên thành viên:',
'editusergroup'              => 'Sửa các nhóm thành viên',
'userrights-editusergroup'   => 'Sửa nhóm thành viên',
'saveusergroups'             => 'Lưu nhóm thành viên',
'userrights-groupsmember'    => 'Thành viên của:',
'userrights-groupsavailable' => 'Các nhóm hiện nay:',
'userrights-groupshelp'      => 'Chọn nhóm mà bạn muốn thêm hay bớt thành viên. Các nhóm không được chọn sẽ không thay đổi. Có thể chọn nhóm bằng CTRL + Chuột trái',

# User rights log
'rightslogtext' => 'Đây là nhật trình lưu những thay đổi đối với các quyền hạn thành viên.',

# Recent changes
'recentchanges'                     => 'Thay đổi gần đây',
'recentchangestext'                 => '[[{{ns:4}}:Chào mừng người mới đến|Chào mừng]] bạn! Trang này dùng để theo dõi các thay đổi gần đây trên {{SITENAME}}.',
'rcnote'                            => '<strong>$1</strong> thay đổi của <strong>$2</strong> ngày qua.',
'rcnotefrom'                        => 'Thay đổi từ <strong>$2</strong> (<b>$1</b> tối đa).',
'rclistfrom'                        => 'Xem thay đổi từ $1.',
'rclinks'                           => 'Xem $1 thay đổi của $2 ngày qua; $3.',
'diff'                              => 'khác',
'hist'                              => 'sử',
'hide'                              => 'giấu',
'show'                              => 'xem',
'minoreditletter'                   => 'n',
'newpageletter'                     => 'M',
'number_of_watching_users_pageview' => ' [$1 người xem]',

# Recent changes linked
'recentchangeslinked' => 'Thay đổi liên quan',

# Upload
'upload'                     => 'Tải lên',
'uploadbtn'                  => 'Tải lên',
'reupload'                   => 'Tải lại',
'reuploaddesc'               => 'Quay lại.',
'uploadnologin'              => 'Chưa đăng nhập',
'uploadnologintext'          => 'Bạn phải [[Đặc_biệt:Userlogin|đăng nhập]] để tải lên tệp tin.',
'upload_directory_read_only' => 'Thư mục tải lên không ghi vào được',
'uploaderror'                => 'Lỗi',
'uploadtext'                 => 'Trước khi truyền hình lên:
*Kiểm tra hình ảnh đã tải lên trước đây tại [[Đặc_biệt:Imagelist|danh sách những hình đã tải lên]].
Khi truyền hình lên:
*Tuân thủ [[{{ns:4}}:Quy định về hình ảnh|quy định về sử dụng hình ảnh]].
*Ghi rõ thẻ quyền. Ví dụ {{<nowiki>PD</nowiki>}} hay {{<nowiki>GFDL</nowiki>}},... Xem thêm [[{{ns:4}}:Thẻ quyền cho hình ảnh|thẻ quyền cho hình ảnh]].
*Dùng định dạng JPEG cho ảnh chụp, PNG cho hình vẽ, và OGG cho âm thanh hay video.
*Ghi tóm lược về hình ảnh giúp người khác có thể dùng lại hình của bạn.
Sau khi truyền hình lên:
*Thông tin tải lên và xóa bỏ được ghi trong [[{{ns:4}}:Nhật trình tải lên|nhật trình tải lên]].
*Để cho hình vào bài, xem [[{{ns:4}}:Cú pháp hình ảnh|cú pháp hình ảnh]].
*Người khác có thể sửa hoặc xóa những thông tin bạn tải lên, và bạn có thể bị cấm tải lên nếu lạm dụng hệ thống.',
'uploadlog'                  => 'Nhật trình tải lên',
'uploadlogpage'              => 'Nhật_trình_tải_lên',
'uploadlogpagetext'          => 'Danh sách các tệp tin đã tải lên, theo giờ máy chủ (UTC).
<ul>
</ul>',
'filename'                   => 'Tên&nbsp;',
'filedesc'                   => 'Mô tả&nbsp;',
'fileuploadsummary'          => 'tóm tắt',
'filestatus'                 => 'Bản quyền',
'filesource'                 => 'Nguồn',
'uploadedfiles'              => 'Đã tải xong',
'minlength'                  => 'Tên phải dài hơn hai chữ.',
'illegalfilename'            => 'Tên « $1 » có chứa ký tự không dùng được cho tên trang. Xin hãy đổi tên và tải lại.',
'badfilename'                => 'Đổi thành tên « $1 ».',
'emptyfile'                  => 'Tệp tin tải lên là rỗng. Xin kiểm tra lại tên tệp tin.',
'fileexists'                 => "'Một tệp tin với tên này đã tồn tại, xin hãy kiểm tra $1 nếu bạn không muốn thay đổi nó.",
'successfulupload'           => 'Đã tải xong',
'fileuploaded'               => 'Tập tin "$1" đã được tải lên thành công.
Xin hãy theo liên kết: $2 đến trang mô tả và điền vào thông tin về tập tin, chẳng hạn như nó đến từ đâu, được tạo ra khi nào và bởi ai, và các chi tiết khác mà bạn biết về nó.
Nếu đây là hình ảnh, bạn có thể cho vào trong trang như sau:
<tt><nowiki>[[Image:$1|thumb|Mô tả hình]]</nowiki></tt>.',
'uploadwarning'              => 'Chú ý!',
'savefile'                   => 'Lưu tệp tin',
'uploadedimage'              => 'đã tải lên « [[$1]] »',
'uploaddisabled'             => 'Xin lỗi, chức năng tải lên bị khóa.',
'uploadcorrupt'              => 'Tập tin bị hỏng hoặc có đuôi không chuẩn. Xin kiểm tra và tải lại.',
'uploadvirus'                => 'Tệp tin có virút: $1',
'sourcefilename'             => 'Tên tệp tin nguồn',
'destfilename'               => 'Tên mới',

'nolicense' => 'chưa chọn',

# Image list
'imagelist'                 => 'Danh sách hình',
'imagelisttext'             => 'Danh sách $1 hình xếp theo $2.',
'getimagelist'              => 'Đang lấy danh sách hình',
'ilsubmit'                  => 'Tìm',
'showlast'                  => 'Xem $1 hình mới nhất xếp theo $2.',
'byname'                    => 'tên',
'bydate'                    => 'ngày',
'bysize'                    => 'kích cỡ',
'imgdelete'                 => 'xóa',
'imgdesc'                   => 'tả',
'imglegend'                 => 'Chú thích: (tả) = xem/sửa mô tả về hình.',
'imghistory'                => 'Lịch sử hình',
'revertimg'                 => 'hồi',
'deleteimg'                 => 'xóa',
'deleteimgcompletely'       => 'xóa hẳn',
'imghistlegend'             => 'Chú thích: (nay) = Hình hiện nay, (xóa) = Xóa bản cũ, (hồi) = Phục hồi bản cũ.
<br /><i>Ấn vào ngày để xem hình tải lên ngày đó</i>.',
'imagelinks'                => 'Liên kết đến hình',
'linkstoimage'              => 'Các trang sau có liên kết đến hình:',
'nolinkstoimage'            => 'Không có trang nào chứa liên kết đến hình.',
'shareduploadwiki'          => 'Xin xem thêm [$1 mô tả tệp tin]',
'noimage'                   => 'Không có hình này, bạn có thể [$1 tải nó lên]',
'noimage-linktext'          => 'tải lên',
'uploadnewversion-linktext' => 'Tải lên phiên bản mới',

# Statistics
'statistics'    => 'Thống kê',
'sitestats'     => 'Thống kê',
'userstats'     => 'Thống kê thành viên',
'sitestatstext' => '<p style="font-size: 125%; margin-bottom: 0px">Hiện đang có <b>$2</b> [[{{ns:4}}:Bài bách khoa là gì?|bài viết]].</p>

Con số này không bao gồm các trang [[{{ns:4}}:Trang_thảo_luận|thảo luận]], các trang giới thiệu {{SITENAME}}, các [[{{ns:4}}:Trang_đổi_hướng|trang đổi hướng]], và các trang không được coi là có nội dung (ví dụ: không liên kết đến trang khác). Khi tính các trang đó vào, có <b>$1</b> trang.

Đã có tổng cộng <b>$3</b> lần xem, và <b>$4</b> lần sửa kể từ khi dự án này được thiết lập. Trung bình có <b>$5</b> lần sửa cho mỗi trang, và <b>$6</b> lần xem cho mỗi sửa đổi.',
'userstatstext' => 'Có <b>$1</b> thành viên đã đăng ký, trong đó có <b>$2</b> là [[{{ns:4}}:Người quản lý|người quản lý]].',

'disambiguations'     => 'Trang định hướng',
'disambiguationspage' => '{{ns:4}}:Trang_định_hướng',

'doubleredirects'     => 'Đổi hướng kép',
'doubleredirectstext' => 'Mỗi hàng có chứa các liên kết đến trang chuyển hướng thứ nhất và thứ hai, cũng như dòng đầu tiên của nội dung trang chuyển hướng thứ hai, thường chỉ tới trang đích "thực sự", là nơi mà trang chuyển hướng đầu tiên phải trỏ đến.',

'brokenredirects'     => 'Đổi hướng sai',
'brokenredirectstext' => 'Các trang đổi hướng sau đây liên kết đến một trang không tồn tại.',

# Miscellaneous special pages
'nbytes'                  => '$1 byte',
'nlinks'                  => '$1 liên kết',
'nviews'                  => '$1 lần xem',
'lonelypages'             => 'Trang mồ côi',
'uncategorizedpages'      => 'Trang chưa xếp thể loại',
'uncategorizedcategories' => 'Thể loại chưa phân loại',
'unusedcategories'        => 'Thể loại chưa dùng',
'unusedimages'            => 'Hình chưa dùng',
'popularpages'            => 'Trang nhiều người đọc',
'wantedpages'             => 'Trang cần viết',
'mostlinked'              => 'Trang được liên kết đến nhiều nhất',
'allpages'                => 'Tất cả các trang',
'prefixindex'             => 'Mục lục theo không gian tên',
'randompage'              => 'Trang ngẫu nhiên',
'shortpages'              => 'Bài ngắn',
'longpages'               => 'Bài dài',
'deadendpages'            => 'Trang đường cùng',
'listusers'               => 'Danh sách thành viên',
'specialpages'            => 'Các trang đặc biệt',
'spheading'               => 'Các trang đặc biệt',
'restrictedpheading'      => 'Trang đặc biệt hạn chế',
'rclsub'                  => '(trang liên kết đến "$1")',
'newpages'                => 'Các bài mới nhất',
'ancientpages'            => 'Các bài cũ nhất',
'intl'                    => 'Liên kết liên ngôn ngữ',
'move'                    => 'đổi tên',
'movethispage'            => 'Đổi tên trang này',
'unusedimagestext'        => '<p>Xin lưu ý là các địa chỉ mạng bên ngoài có thể liên kết đến một hình ở đây qua một địa chỉ trực tiếp, dù hình này được liệt kê là chưa dùng.</p>',

# Book sources
'booksources' => 'Nguồn tham khảo',

'categoriespagetext' => 'Các thể loại :',
'data'               => 'dữ liệu',
'userrights'         => 'Quản lý quyền thành viên',
'groups'             => 'Các nhóm',
'alphaindexline'     => '$1 đến $2',
'version'            => 'Phiên bản',

# Special:Log
'specialloguserlabel'  => 'Thành viên:',
'speciallogtitlelabel' => 'Tên bài:',
'log'                  => 'Nhật trình',
'alllogstext'          => 'Xem nhật trình tải lên, xóa, khóa, cấm, quản lý. Có thể xem theo từng loại, theo tên thành viên, hoặc tên trang.',

# Special:Allpages
'nextpage'          => 'Bài sau ($1)',
'allpagesfrom'      => 'Xem trang từ:',
'allarticles'       => 'Mọi bài',
'allinnamespace'    => 'Mọi trang (không gian $1)',
'allnotinnamespace' => 'Mọi trang (không trong không gian $1)',
'allpagesprev'      => 'Trước',
'allpagesnext'      => 'Sau',
'allpagessubmit'    => 'Hiển thị',

# E-mail user
'mailnologin'     => 'Không có địa chỉ gửi thư',
'mailnologintext' => 'Bạn phải [[Đặc_biệt:Userlogin|đăng nhập]] và có khai báo một địa chỉ thư điện tử hợp lệ trong phần [[Đặc_biệt:Preferences|lựa chọn cá nhân]] thì mới gửi được thư cho người khác.',
'emailuser'       => 'Gửi thư cho người này',
'emailpage'       => 'Gửi thư',
'emailpagetext'   => 'Nếu người này đã cung cấp địa chỉ thư điện tử, biểu mẫu dưới đây sẽ cho bạn gửi thư. Địa chỉ thư điện tử của bạn sẽ xuất hiện trong phần địa chỉ người gửi của bức thư, nên người nhận có thể trả lời lại bạn.',
'usermailererror' => 'Lỗi gửi thư:',
'defemailsubject' => 'thư gửi từ {{SITENAME}}',
'noemailtitle'    => 'Không có địa chỉ nhận thư',
'noemailtext'     => 'Người này không cung cấp một địa chỉ thư hợp lệ, hoặc đã chọn không nhận thư từ người khác.',
'emailfrom'       => 'Từ',
'emailto'         => 'Đến',
'emailsubject'    => 'Chủ đề',
'emailmessage'    => 'Nội dung',
'emailsend'       => 'Gửi',
'emailsent'       => 'Đã gửi',
'emailsenttext'   => 'Thư của bạn đã được gửi.',

# Watchlist
'watchlist'            => 'Trang tôi theo dõi',
'mywatchlist'          => 'Trang tôi theo dõi',
'nowatchlist'          => 'Chưa có gì.',
'watchnologin'         => 'Chưa đăng nhập',
'watchnologintext'     => 'Bạn phải [[Đặc_biệt:Userlogin|đăng nhập]] mới sửa đổi được danh sách theo dõi.',
'addedwatch'           => 'Đã vào danh sách theo dõi',
'addedwatchtext'       => 'Trang "$1" đã được cho vào [[Đặc_biệt:Watchlist|danh sách theo dõi]].
Những sửa đổi đối với trang này và trang thảo luận của nó sẽ được liệt kê, và được <b>in đậm</b> trong [[Đặc_biệt:Recentchanges|danh sách các thay đổi mới]].
<p>Nếu bạn muốn cho trang này ra khỏi danh sách theo dõi, nhấn vào "Ngừng theo dõi" ở trên.',
'removedwatch'         => 'Đã ra khỏi danh sách theo dõi',
'removedwatchtext'     => 'Trang « $1 » đã ra khỏi danh sách theo dõi.',
'watch'                => 'Theo dõi',
'watchthispage'        => 'Theo dõi trang này',
'unwatch'              => 'ngừng theo dõi',
'unwatchthispage'      => 'Ngừng theo dõi',
'notanarticle'         => 'Không phải bài viết',
'watchnochange'        => 'Không có trang nào bạn theo dõi được sửa đổi.',
'watchdetails'         => '* Bạn theo dõi $1 trang không kể trang thảo luận. $3 <br />
*[$4 Xem và sửa lại danh sách]',
'wlheader-enotif'      => '* Đã bật thông báo qua thư điện tử.',
'wlheader-showupdated' => "* Các trang đã thay đổi từ lần cuối bạn xem chúng được in '''đậm'''",
'watchmethod-recent'   => 'Dưới đây hiện thay đổi mới với các trang theo dõi.',
'watchmethod-list'     => 'Dưới đây hiện danh sách các trang theo dõi.',
'removechecked'        => 'Ngưng theo dõi mục đã chọn',
'watchlistcontains'    => 'Danh sách theo dõi của bạn có $1 trang.',
'watcheditlist'        => 'Đây là sắp xếp theo chữ cái các trang bạn theo dõi. Chọn các trang bạn muốn ngưng theo dõi và nhấn "Ngưng theo dõi mục đã chọn".',
'removingchecked'      => 'Đang ngưng theo dõi trang yêu cầu...',
'couldntremove'        => "Không thể ngưng theo dõi trang '$1'...",
'iteminvalidname'      => "Tên trang '$1' không hợp lệ...",
'wlnote'               => '$1 sửa đổi mới trong <b>$2</b> giờ qua.',
'wlshowlast'           => 'Xem $1 giờ $2 ngày qua, hoặc $3',
'wlsaved'              => 'Đây là bản lưu danh sách theo dõi.',

'enotif_mailer'      => 'Thông báo của {{SITENAME}}',
'enotif_reset'       => 'Đánh dấu đã xem mọi trang',
'enotif_newpagetext' => 'Trang này mới',
'changed'            => 'Đã sửa',
'created'            => 'đã viết mới',
'enotif_subject'     => '$PAGETITLE tại {{SITENAME}} đã thay đổi $CHANGEDORCREATED bởi $PAGEEDITOR',
'enotif_lastvisited' => 'Xem {{fullurl:$PAGETITLE_RAWURL|diff=0&oldid=$OLDID}} để biết các thay đổi từ khi bạn xem lần cuối.',
'enotif_body'        => 'Gửi $WATCHINGUSERNAME,  trang $PAGETITLE tại {{SITENAME}} đã được $CHANGEDORCREATED vào $PAGEEDITDATE bởi $PAGEEDITOR, xem {{fullurl:$PAGETITLE_RAWURL}} để biết phiên bản hiện nay. Tóm tắt của $NEWPAGE: $PAGESUMMARY $PAGEMINOREDIT Liên hệ người sửa: thư {{fullurl:Special:Emailuser|target=$PAGEEDITOR_RAWURL}}  {{fullurl:User:$PAGEEDITOR_RAWURL}} Sẽ không có thông báo mới nếu bạn không xem trang này. Bạn có thể thay đổi các cài đặt về các trang theo dõi. Hệ thống thông báo {{SITENAME}} -- Để thay đổi cài đặt, mời vào {{fullurl:Special:Watchlist|edit=yes}} Góp ý của bạn: {{fullurl:Help:Contents}}',

# Delete/protect/revert
'deletepage'         => 'Xóa trang',
'confirm'            => 'Khẳng định',
'excontent'          => 'nội dung cũ là:',
'excontentauthor'    => 'nội dung cũ: "$1" (người viết duy nhất "$2")',
'exbeforeblank'      => 'nội dung trước khi xóa là:',
'exblank'            => 'trang rỗng',
'confirmdelete'      => 'Khẳng định xóa',
'deletesub'          => '(Xóa  "$1")',
'historywarning'     => '<b>Chú ý</b>: trang bạn sắp xóa đã có lịch sử:',
'confirmdeletetext'  => 'Bạn sắp xóa hẳn một trang hoặc hình cùng với tất cả lịch sử của nó khỏi cơ sở dữ liệu. Xin khẳng định bạn hiểu rõ hậu quả có thể xảy ra, và bạn thực hiện đúng [[{{ns:4}}:Quy_định|quy định]].',
'actioncomplete'     => 'Xong',
'deletedtext'        => '"$1" đã được xóa. Xem danh sách các xóa bỏ gần nhất tại $2.',
'deletedarticle'     => 'đã xóa "$1"',
'dellogpage'         => 'Nhật trình xóa',
'dellogpagetext'     => 'Danh sách xóa mới, theo giờ máy chủ (UTC).
<ul>
</ul>',
'deletionlog'        => 'nhật trình xóa',
'reverted'           => 'Đã quay lại phiên bản cũ',
'deletecomment'      => 'Lý do',
'imagereverted'      => 'Đã quay lại phiên bản cũ.',
'rollback'           => 'Quay lại sửa đổi cũ',
'rollback_short'     => 'Quay lại',
'rollbacklink'       => 'quay lại',
'rollbackfailed'     => 'Không quay lại được',
'cantrollback'       => 'Không quay lại được; trang này có 1 tác giả.',
'alreadyrolled'      => 'Không thể quay lại phiên bản của [[:$1]] bởi [[Thành_viên:$2|$2]] ([[Thảo_luận_thành_viên:$2|Thảo luận]]). Đã có sửa đổi lần cuối bởi [[Thành_viên:$3|$3]] ([[Thảo_luận_thành_viên:$3|Thảo luận]]).',
'editcomment'        => 'Tóm lược sửa đổi: "<i>$1</i>".', # only shown if there is an edit comment
'revertpage'         => 'đã hủy sửa đổi của $2, quay về phiên bản của $1',
'sessionfailure'     => 'Có thể có trục trặc với phiên đăng nhập của bạn; thao tác này đã bị hủy để tránh việc cướp quyền đăng nhập. Xin hãy tải lại trang và thử lại.',
'protectlogpage'     => 'Nhật trình khóa',
'protectlogtext'     => 'Danh sách khóa/mở (xem [[{{ns:4}}:Các trang bị khóa|các trang bị khóa]]).',
'protectedarticle'   => 'đã khóa $1',
'unprotectedarticle' => 'đã mở $1',
'protectsub'         => '(Khóa "$1")',
'confirmprotect'     => 'Khẳng định khóa',
'protectcomment'     => 'Lý do',
'unprotectsub'       => '(Mở "$1")',

# Undelete
'undelete'           => 'Khôi phục',
'undeletepage'       => 'Xem và khôi phục trang bị xóa',
'undeletepagetext'   => 'Các trang sau có thể khôi phục được từ thùng rác. Thùng rác được xóa định kỳ.',
'undeleterevisions'  => '$1 bản được lưu',
'undeletehistory'    => 'Nếu bạn khôi phục trang này, tất cả các phiên bản của nó sẽ được phục hồi vào lịch sử của trang. Nếu một trang mới có cùng tên đã được tạo ra kể từ khi xóa trang này, các phiên bản được khôi phục sẽ xuất hiện trong lịch sử trước, và phiên bản hiện hành của trang mới sẽ không bị thay thế.',
'undeletebtn'        => 'Khôi phục',
'undeletedarticle'   => 'đã khôi phục "$1"',
'undeletedrevisions' => '$1 bản được khôi phục',

# Namespace form on various pages
'namespace' => 'Không gian:',
'invert'    => 'Đảo ngược lựa chọn',

# Contributions
'contributions' => 'Đóng góp',
'mycontris'     => 'Đóng góp của tôi',
'contribsub2'   => 'Của $1 ($2)',
'nocontribs'    => 'Không tìm thấy.',
'ucnote'        => '<b>$1</b> thay đổi mới của người này trong <b>$2</b> ngày qua.',
'uclinks'       => 'Xem $1 thay đổi mới; xem $2 ngày qua.',
'uctop'         => '(mới nhất)',

# What links here
'whatlinkshere' => 'Liên kết đến đây',
'notargettitle' => 'Không hiểu',
'notargettext'  => 'Xin chỉ rõ trang mục tiêu.',
'linklistsub'   => '(Các liên kết)',
'linkshere'     => 'Các trang sau liên kết đến đây:',
'nolinkshere'   => 'Không có liên kết đến đây.',
'isredirect'    => 'trang đổi hướng',

# Block/unblock
'blockip'                     => 'Cấm thành viên',
'blockiptext'                 => 'Mẫu dưới để cấm một địa chỉ IP hoặc một tài khoản.
Chức năng này chỉ nên dùng để ngăn những hành vi phá hoại, và phải tuân theo [[{{ns:4}}:Quy_định|quy_định]]. Xin cho biết lý do cấm.',
'ipaddress'                   => 'Địa chỉ IP/tên tài khoản',
'ipadressorusername'          => 'Địa chỉ IP hay tên thành viên',
'ipbexpiry'                   => 'Thời hạn',
'ipbreason'                   => 'Lý do',
'ipbsubmit'                   => 'Cấm',
'ipbother'                    => 'Thời hạn khác',
'ipboptions'                  => '2 giờ:2 hours,1 ngày:1 day,3 ngày:3 days,1 tuần:1 week,2 tuần:2 weeks,1 tháng:1 month,3 tháng:3 months,6 tháng:6 months,1 năm:1 year,vô hạn:infinite',
'ipbotheroption'              => 'khác',
'badipaddress'                => 'Địa chỉ IP không hợp lệ',
'blockipsuccesssub'           => 'Đã cấm',
'blockipsuccesstext'          => '"$1" đã bị cấm.
<br />Xem lại những lần cấm tại [[Đặc_biệt:Ipblocklist|danh sách cấm]].',
'unblockip'                   => 'Bỏ cấm',
'unblockiptext'               => 'Mẫu sau để khôi phục lại quyền sửa bài đối với một địa chỉ IP hoặc tài khoản đã bị cấm trước đó.',
'ipusubmit'                   => 'Bỏ cấm',
'ipblocklist'                 => 'Danh sách cấm',
'blocklistline'               => '$1, $2 đã cấm $3 (thời hạn $4)',
'blocklink'                   => 'cấm',
'unblocklink'                 => 'bỏ cấm',
'contribslink'                => 'đóng góp',
'autoblocker'                 => 'Bị tự động cấm vì dùng chung địa chỉ IP với "$1". Lý do "$2".',
'blocklogpage'                => 'Nhật trình cấm',
'blocklogentry'               => 'đã cấm "$1", thời hạn $2',
'blocklogtext'                => 'Nhật trình lưu những lần cấm và bỏ cấm. Các địa chỉ IP bị cấm tự động không được liệt kê. Xem thêm
[[Đặc_biệt:Ipblocklist|danh sách cấm]].',
'unblocklogentry'             => 'đã hết cấm "$1"',
'range_block_disabled'        => 'Không được cấm hàng loạt.',
'ipb_expiry_invalid'          => 'Thời điểm hết hạn không hợp lệ.',
'ip_range_invalid'            => 'Dải IP không hợp lệ.',
'proxyblocker'                => 'Chặn proxy',
'proxyblockreason'            => 'Địa chỉ IP của bạn đã bị cấm vì là proxy mở. Xin hãy liên hệ nhà cung cấp dịch vụ Internet hoặc bộ phận hỗ trợ kỹ thuật của bạn và thông báo với họ về vấn đề an ninh nghiêm trọng này.',
'proxyblocksuccess'           => 'Xong.',
'sorbs'                       => 'SORBS DNSBL',
'sorbsreason'                 => 'Địa chỉ IP của bạn bị liệt kê là một proxy mở theo [http://www.sorbs.net SORBS] DNSBL.',
'sorbs_create_account_reason' => 'Địa chỉ IP của bạn bị liệt kê là một proxy mở theo [http://www.sorbs.net SORBS] DNSBL. Bạn không thể mở được tài khoản.',

# Developer tools
'lockdb'              => 'Khóa cơ sở dữ liệu',
'unlockdb'            => 'Mở cơ sở dữ liệu',
'lockdbtext'          => 'Khóa cơ sở dữ liệu sẽ không cho phép người dùng sửa đổi các trang, thay đổi thông số cá nhân của họ, sửa danh sách theo dõi, và những thao tác khác đòi hỏi phải thay đổi trong cơ sở dữ liệu.
Xin hãy khẳng định là bạn có ý định thực hiện điều này, và bạn sẽ mở khóa cơ sở dữ liệu khi xong công việc bảo trì của bạn.',
'unlockdbtext'        => 'Mở khóa cơ sở dữ liệu sẽ lại cho phép các người dùng có thể sửa đổi trang, thay đổi thông số cá nhân của họ, sửa đổi danh sách theo dõi của họ, và nhiều thao tác khác đòi hỏi phải có thay đổi trong cơ sở dữ liệu.
Xin hãy khẳng định đây là điều bạn định làm.',
'lockconfirm'         => 'Vâng, tôi thực sự muốn khóa cơ sở dữ liệu.',
'unlockconfirm'       => 'Vâng, tôi thực sự muốn mở cơ sở dữ liệu.',
'lockbtn'             => 'Khóa cơ sở dữ liệu',
'unlockbtn'           => 'Mở cơ sở dữ liệu',
'locknoconfirm'       => 'Bạn đã không chọn vào ô khẳng định.',
'lockdbsuccesssub'    => 'Khóa thành công cơ sở dữ liệu',
'unlockdbsuccesssub'  => 'Mở thành công cơ sở dữ liệu',
'lockdbsuccesstext'   => 'Cơ sở dữ liệu đã bị khóa.
<br />Nhớ bỏ khóa sau khi bảo trì xong.',
'unlockdbsuccesstext' => 'Cơ sở dữ liệu đã được mở khóa.',

# Move page
'movepage'               => 'Di chuyển',
'movepagetext'           => 'Dùng mẫu dưới đây sẽ đổi tên một trang, đồng thời chuyển tất cả lịch sử của nó sang tên mới.
*Tên cũ sẽ tự động đổi hướng sang tên mới.
*Trang sẽ <b>không</b> bị chuyển nếu đã có một trang tại tên mới, trừ khi nó rỗng hoặc là trang đổi hướng và không có lịch sử sửa đổi. Điều này có nghĩa là bạn có thể đổi tên một trang lại như trước lúc nó được đổi tên nếu bạn nhầm, và bạn không thể ghi đè một trang đã có sẵn.
*Những liên kết đến tên trang cũ sẽ không thay đổi; cần [[Đặc_biệt:DoubleRedirects|kiểm tra]] những trang chuyển hướng kép và sai.<br />
<b>Bạn phải đảm bảo những liên kết tiếp tục trỏ đến đúng trang cần thiết.</b>',
'movepagetalktext'       => "Trang thảo luận đi kèm nếu có, sẽ được tự động chuyển theo '''trừ khi:'''
*Bạn đang chuyển xuyên qua không gian tên,
*Một trang thảo luận đã tồn tại dưới tên bạn chọn, hoặc
*Bạn không chọn vào ô bên dưới.

Trong những trường hợp này, bạn phải di chuyển hoặc hợp nhất trang theo kiểu thủ công nếu muốn.",
'movearticle'            => 'Di chuyển',
'movenologin'            => 'Chưa đăng nhập',
'movenologintext'        => 'Bạn phải [[Đặc_biệt:Userlogin|đăng nhập]] mới di chuyển trang được.',
'newtitle'               => 'Tên mới',
'movepagebtn'            => 'Di chuyển',
'pagemovedsub'           => 'Di chuyển thành công',
'pagemovedtext'          => 'Trang "[[$1]]" đổi thành "[[$2]]".',
'articleexists'          => 'Đã có một trang với tên đó, hoặc tên bạn chọn không hợp lệ.
Xin hãy chọn tên khác.',
'talkexists'             => 'Trang được di chuyển thành công, nhưng trang thảo luận tương ứng không thể chuyển được vì đã có một trang thảo luận ở tên mới.
Xin hãy hợp nhất chúng lại.',
'movedto'                => 'đổi thành',
'movetalk'               => 'Di chuyển trang "thảo luận" nếu có.',
'talkpagemoved'          => 'Trang thảo luận tương ứng đã chuyển.',
'talkpagenotmoved'       => 'Trang thảo luận tương ứng <strong>không</strong> chuyển.',
'1movedto2'              => '$1 đổi thành $2',
'1movedto2_redir'        => '$1 đổi thành $2 qua đổi hướng',
'movelogpage'            => 'Nhật trình đổi tên',
'movelogpagetext'        => 'Các trang bị đổi tên.',
'movereason'             => 'Lý do',
'revertmove'             => 'lùi lại',
'delete_and_move'        => 'Xóa và đổi tên',
'delete_and_move_text'   => ' ==Cần xóa==
Bài với tên "[[$1]]" đã tồn tại. Bạn có muốn xóa nó để di chuyển tới tên này không?',
'delete_and_move_reason' => 'Xóa để có chỗ đổi tên',
'selfmove'               => 'Tên mới giống tên cũ; không đổi tên được.',
'immobile_namespace'     => 'Tên mới đặc biệt; không đổi sang tên đó được.',

# Export
'export'        => 'Xuất các trang',
'exporttext'    => 'Bạn có thể xuất nội dung và lịch sử sửa đổi của một trang hay tập hợp trang nào đó vào trong các XML. Trong tương lai, cũng có thể nhập vào một mạng khác chạy phần mềm MediaWiki.

Để xuất nội dung các bài, gõ vào tên bài trong cửa sổ dưới đây, mỗi tên một hàng, và cho biết là bạn muốn chọn phiên bản hiện tại cùng với các phiên bản cũ của nó, với các dòng về lịch sử trang, hay chỉ phiên bản hiện hành với thông tin về lần sửa đổi cuối cùng.',
'exportcuronly' => 'Chỉ xuất phiên bản hiện hành, không xuất tất cả lịch sử trang',

# Namespace 8 related
'allmessages'               => 'Thông báo hệ thống',
'allmessagesname'           => 'Tên thông báo',
'allmessagesdefault'        => 'Nội dung mặc định',
'allmessagescurrent'        => 'Nội dung hiện thời',
'allmessagestext'           => 'Đây là toàn bộ thông báo hệ thống có trong không gian tên MediaWiki: .',
'allmessagesnotsupportedUI' => 'Ngôn ngữ giao diện hiện tại của bạn <b>$1</b> không được Đặc_biệt:AllMessages hỗ trợ tại đây.',
'allmessagesnotsupportedDB' => 'Đặc_biệt:AllMessages không được hỗ trợ vì wgUseDatabaseMessages bị tắt.',

# Thumbnails
'thumbnail-more' => 'Phóng lớn',
'missingimage'   => '<b>Không có hình</b><br /><i>$1</i>',
'filemissing'    => 'Không có tệp tin',

# Special:Import
'import'                => 'Nhập các trang',
'importinterwiki'       => 'Nhập giữa các wiki',
'importtext'            => 'Xin hãy xuất tập tin từ wiki nguồn sử dụng công cụ Đặc_biệt:Export, lưu nó vào đĩa và tải lên ở đây.',
'importfailed'          => 'Không nhập được: $1',
'importnotext'          => 'Trang trống không có nội dung',
'importsuccess'         => 'Nhập thành công!',
'importhistoryconflict' => 'Có mâu thuẫn trong lịch sử của các phiên bản (trang này có thể đã được nhập vào trước đó)',
'importnosources'       => 'Không có nguồn nhập giữa wiki và việc nhập lịch sử bị tắt.',

# Tooltip help for the actions
'tooltip-pt-userpage'             => 'Trang của tôi',
'tooltip-pt-anonuserpage'         => 'Trang của IP bạn đang dùng',
'tooltip-pt-mytalk'               => 'Thảo luận với tôi',
'tooltip-pt-anontalk'             => 'Thảo luận với địa chỉ IP này',
'tooltip-pt-preferences'          => 'Lựa chọn cá nhân của tôi',
'tooltip-pt-watchlist'            => 'Thay đổi của các trang tôi theo dõi.',
'tooltip-pt-mycontris'            => 'Đóng góp của tôi',
'tooltip-pt-login'                => 'Đăng nhập sẽ có lợi hơn, tuy nhiên không bắt buộc.',
'tooltip-pt-anonlogin'            => 'Không đăng nhập vẫn tham gia được, tuy nhiên đăng nhập sẽ lợi hơn.',
'tooltip-pt-logout'               => 'Đăng xuất',
'tooltip-ca-talk'                 => 'Thảo luận về trang này',
'tooltip-ca-edit'                 => 'Bạn có thể sửa được trang này. Xin xem thử trước khi lưu.',
'tooltip-ca-addsection'           => 'Thêm bình luận vào đây.',
'tooltip-ca-viewsource'           => 'Trang này được khóa. Bạn có thể xem mã nguồn.',
'tooltip-ca-history'              => 'Những phiên bản cũ của trang này.',
'tooltip-ca-protect'              => 'Khóa trang này lại',
'tooltip-ca-delete'               => 'Xóa trang này',
'tooltip-ca-undelete'             => 'Khôi phục lại những sửa đổi trên trang này trước khi nó bị xóa',
'tooltip-ca-move'                 => 'Di chuyển trang này',
'tooltip-ca-watch'                => 'Thêm trang này vào danh sách theo dõi',
'tooltip-ca-unwatch'              => 'Bỏ trang này khỏi danh sách theo dõi',
'tooltip-search'                  => 'Tìm kiếm',
'tooltip-p-logo'                  => 'Trang đầu',
'tooltip-n-mainpage'              => 'Trang đầu của dự án mở',
'tooltip-n-portal'                => 'Giới thiệu dự án, cách sử dụng, tìm kiếm thông tin ở đây',
'tooltip-n-currentevents'         => 'Xem thời sự',
'tooltip-n-recentchanges'         => 'Danh sách các thay đổi gần đây',
'tooltip-n-randompage'            => 'Xem trang ngẫu nhiên',
'tooltip-n-help'                  => 'Nơi tìm hiểu thêm cách dùng.',
'tooltip-n-sitesupport'           => 'Quyên góp xây dựng dự án mở',
'tooltip-t-whatlinkshere'         => 'Các trang liên kết đến đây',
'tooltip-t-recentchangeslinked'   => 'Thay đổi gần đây của các trang liên kết đến đây',
'tooltip-feed-rss'                => 'Nạp RSS cho trang này',
'tooltip-feed-atom'               => 'Nạp Atom cho trang này',
'tooltip-t-contributions'         => 'Xem đóng góp của người này',
'tooltip-t-emailuser'             => 'Gửi thư cho người này',
'tooltip-t-upload'                => 'Tải hình ảnh hoặc tệp tin lên',
'tooltip-t-specialpages'          => 'Danh sách các trang đặc biệt',
'tooltip-ca-nstab-main'           => 'Xem trang này',
'tooltip-ca-nstab-user'           => 'Xem trang về người này',
'tooltip-ca-nstab-media'          => 'Xem trang phương tiện',
'tooltip-ca-nstab-special'        => 'Đây là một trang dặc biệt, bạn không thể sửa đổi được nó.',
'tooltip-ca-nstab-project'        => 'Xem trang dự án',
'tooltip-ca-nstab-image'          => 'Xem trang hình',
'tooltip-ca-nstab-mediawiki'      => 'Xem thông báo hệ thống',
'tooltip-ca-nstab-template'       => 'Xem tiêu bản',
'tooltip-ca-nstab-help'           => 'Xem trang trợ giúp',
'tooltip-ca-nstab-category'       => 'Xem trang thể loại',
'tooltip-minoredit'               => 'Đánh dấu đây là sửa đổi nhỏ',
'tooltip-save'                    => 'Lưu lại những thay đổi của bạn',
'tooltip-preview'                 => 'Xem thử những thay đổi trước khi lưu!',
'tooltip-diff'                    => 'Xem thay đổi bạn đã thực hiện',
'tooltip-compareselectedversions' => 'Xem khác biệt giữa hai phiên bản của trang này.',
'tooltip-watch'                   => 'Cho trang này vào danh sách theo dõi',

# Stylesheets
'monobook.css' => '/* edit this file to customize the monobook skin for the entire site */',

# Scripts
'monobook.js' => '/* Deprecated; use [[MediaWiki:common.js]] */',

# Metadata
'nodublincore'      => 'Máy chủ không hỗ trợ siêu dữ liệu Dublin Core RDF.',
'nocreativecommons' => 'Máy chủ không hỗ trợ siêu dữ liệu Creative Commons RDF.',
'notacceptable'     => 'Máy chủ không thể cho ra định dạng dữ liệu tương thích với phần mềm của bạn.',

# Attribution
'anonymous'        => 'Thành viên vô danh của {{SITENAME}}',
'siteuser'         => 'Thành viên $1 của {{SITENAME}}',
'lastmodifiedatby' => 'Trang này được $3 cập nhật lần cuối lúc $2, $1.', # $1 date, $2 time, $3 user
'and'              => 'và',
'othercontribs'    => 'dựa trên công trình của $1.',
'others'           => 'những người khác',
'siteusers'        => 'Thành viên $1 của {{SITENAME}}',
'creditspage'      => 'Trang ghi nhận đóng góp',
'nocredits'        => 'Không có thông tin ghi nhận đóng góp cho trang này.',

# Spam protection
'spamprotectiontitle'    => 'Bộ lọc chống thư rác',
'spamprotectiontext'     => 'Trang bạn muốn lưu bị bộ lọc thư rác chặn lại. Đây có thể do một liên kết dẫn tới một địa chỉ bên ngoài.',
'spamprotectionmatch'    => 'Nội dung sau đây đã kích hoạt bộ lọc thư rác: $1',
'subcategorycount'       => 'Có $1 tiểu thể loại trong thể loại này.',
'categoryarticlecount'   => 'Có $1 bài trong thể loại này.',
'listingcontinuesabbrev' => ' tiếp',

# Info page
'infosubtitle'   => 'Thông tin về trang',
'numedits'       => 'Số lần sửa đổi (bài chính): $1',
'numtalkedits'   => 'Số lần sửa đổi  (trang thảo luận): $1',
'numwatchers'    => 'Số người theo dõi: $1',
'numauthors'     => 'Số người sửa đổi khác nhau (bài chính): $1',
'numtalkauthors' => 'Số người sửa đổi khác nhau (trang thảo luận): $1',

# Math options
'mw_math_png'    => 'Luôn cho ra dạng hình PNG',
'mw_math_simple' => 'HTML nếu rất đơn giản, nếu không PNG',
'mw_math_html'   => 'HTML nếu có thể, nếu không PNG',
'mw_math_source' => 'Để là TeX (cho trình duyệt văn bản)',
'mw_math_modern' => 'Dành cho trình duyệt hiện đại',
'mw_math_mathml' => 'MathML nếu có thể',

# Patrolling
'markaspatrolleddiff'   => 'Đánh dấu tuần tra',
'markaspatrolledtext'   => 'Đánh dấu tuần tra',
'markedaspatrolled'     => 'Đã đánh dấu tuần tra',
'markedaspatrolledtext' => 'Bản được đánh dấu đã tuần tra.',
'rcpatroldisabled'      => '"Thay đổi gần đây" của các trang tuần tra không bật',
'rcpatroldisabledtext'  => 'Chức năng "thay đổi gần đây"  của các trang tuần tra hiện không được bật.',

# Image deletion
'deletedrevision' => 'Đã xóa phiên bản cũ $1.',

# Browsing diffs
'previousdiff' => '&larr; So với trước',
'nextdiff'     => 'So với sau &rarr;',

# Media information
'mediawarning' => " '''Cảnh báo''': Tệp tin này có thể làm hại máy tính của bạn. <hr />",
'imagemaxsize' => 'Giới hạn độ phân giải ảnh là:&nbsp;',
'thumbsize'    => 'Kích thước thu nhỏ:&nbsp;',

'newimages' => 'Trang trưng bày hình ảnh mới',
'noimages'  => 'Chưa có hình',

'passwordtooshort' => 'Mật khẩu cần chứa ít nhất $1 chữ.',

# EXIF tags
'exif-imagewidth'                  => 'Bề ngang',
'exif-imagelength'                 => 'Chiều cao',
'exif-bitspersample'               => 'Bit trên mẫu',
'exif-compression'                 => 'Kiểu nén',
'exif-samplesperpixel'             => 'Số mẫu trên điểm ảnh',
'exif-xresolution'                 => 'Phân giải trên bề ngang',
'exif-yresolution'                 => 'Phân giải theo chiều cao',
'exif-jpeginterchangeformat'       => 'Vị trí SOI JPEG',
'exif-jpeginterchangeformatlength' => 'Kích cỡ (byte) của JPEG',
'exif-transferfunction'            => 'Hàm chuyển đổi',
'exif-datetime'                    => 'Ngày tháng sửa',
'exif-imagedescription'            => 'Tiêu đề của hình',
'exif-make'                        => 'Hãng máy ảnh',
'exif-model'                       => 'Kiểu máy ảnh',
'exif-software'                    => 'Phần mềm đã dùng',
'exif-artist'                      => 'Tác giả',
'exif-copyright'                   => 'Bản quyền',
'exif-exifversion'                 => 'Phiên bản exif',
'exif-colorspace'                  => 'Không gian màu',
'exif-componentsconfiguration'     => 'Ý nghĩa thành phần',
'exif-compressedbitsperpixel'      => 'Độ nén (bit/điểm)',
'exif-makernote'                   => 'Lưu ý của nhà sản xuất',
'exif-relatedsoundfile'            => 'Tệp âm thanh liên quan',
'exif-aperturevalue'               => 'Độ mở ống kính',
'exif-brightnessvalue'             => 'Độ sáng',
'exif-flash'                       => 'Đèn chớp',
'exif-cfapattern'                  => 'Mẫu CFA',
'exif-customrendered'              => 'Sửa hình thủ công',
'exif-whitebalance'                => 'Độ sáng trắng',
'exif-contrast'                    => 'Độ tương phản',
'exif-saturation'                  => 'Độ bão hòa',

# EXIF attributes
'exif-compression-1' => 'Không nén',

'exif-orientation-1' => 'Thường', # 0th row: top; 0th column: left
'exif-orientation-2' => 'Lộn ngược theo phương ngang', # 0th row: top; 0th column: right
'exif-orientation-3' => 'Quay 180°', # 0th row: bottom; 0th column: right
'exif-orientation-4' => 'Lộn ngược theo phương dọc', # 0th row: bottom; 0th column: left
'exif-orientation-5' => 'Quay 90° bên trái và lộn thẳng đứng', # 0th row: left; 0th column: top
'exif-orientation-6' => 'Quay 90° bên phải', # 0th row: right; 0th column: top
'exif-orientation-7' => 'Quay 90° bên phải và lộn thẳng đứng', # 0th row: right; 0th column: bottom
'exif-orientation-8' => 'Quay 90° bên trái', # 0th row: left; 0th column: bottom

'exif-componentsconfiguration-0' => 'không có',

'exif-customrendered-0' => 'Thường',
'exif-customrendered-1' => 'Thủ công',

'exif-contrast-0' => 'Thường',
'exif-contrast-1' => 'Nhẹ',
'exif-contrast-2' => 'Mạnh',

# External editor support
'edit-externally'      => 'Sửa bằng phần mềm bên ngoài',
'edit-externally-help' => '* Xem thêm [http://meta.wikimedia.org/wiki/Help:External_editors hướng dẫn bằng tiếng Anh]',

# 'all' in various places, this might be different for inflected languages
'recentchangesall' => 'tất cả',
'imagelistall'     => 'tất cả',
'watchlistall1'    => 'tất cả',
'watchlistall2'    => 'tất cả',
'namespacesall'    => 'tất cả',

# E-mail address confirmation
'confirmemail'            => 'Xác nhận thư điện tử',
'confirmemail_text'       => 'Cần kiểm tra địa chỉ thư điện tử trước khi lưu. Ấn nút bên dưới để gửi thư xác nhận đến địa chỉ. Thư xác nhận có một mã xác nhận; khi bạn nhập mã xác nhận vào đây, địa chỉ thư điện tử của bạn sẽ được xác nhận.',
'confirmemail_send'       => 'Gửi thư xác nhận',
'confirmemail_sent'       => 'Thư xác nhận đã được gửi',
'confirmemail_sendfailed' => 'Không thể gửi thư xác nhận. Xin kiểm tra lại địa chỉ thư.',
'confirmemail_invalid'    => 'Mã xác nhận sai. Mã này có thể đã hết hạn',
'confirmemail_success'    => 'Thư điện tử của bạn đã được xác nhận. Bạn có thể đăng nhập được.',
'confirmemail_loggedin'   => 'Địa chỉ thư điện tử của bạn đã được xác nhận',
'confirmemail_error'      => 'Có trục trặc',
'confirmemail_subject'    => 'Xác nhận thư điện tử tại {{SITENAME}}',
'confirmemail_body'       => 'Ai đó, có thể là bạn, với địa chỉ thư điện tử $1, đã mở tài khoản "$2" dùng địa chỉ này ở {{SITENAME}}.

Để xác nhận rằng tài khoản này của bạn và dùng chức năng thư điện tử ở {{SITENAME}}, xin mở địa chỉ mạng sau :

$3

Nếu không phải bạn, đừng mở địa chỉ này. Mã xác nhận này sẽ hết hạn lúc $4.',

# Inputbox extension, may be useful in other contexts as well
'tryexact'       => 'Thử tìm đoạn văn khớp chính xác với từ khóa',
'searchfulltext' => 'Tìm toàn văn',
'createarticle'  => 'Viết bài mới',

# Scary transclusion
'scarytranscludedisabled' => 'Liên wiki bị tắt',
'scarytranscludefailed'   => 'Tiêu bản cho $1 bị tắt',
'scarytranscludetoolong'  => 'Địa chỉ mạng dài quá',

);

?>
