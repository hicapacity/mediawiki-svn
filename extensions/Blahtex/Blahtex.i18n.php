<?php
/**
 * Internationalisation file for extension Blahtex.
 *
 * @addtogroup Extensions
*/

$messages = array();

$messages['en'] = array(
	'math_noblahtex'                        => 'Can\'t execute blahtex, which should be at $1',
	'math_AmbiguousInfix'                   => 'Ambiguous placement of "$1" (try using additional braces "{ ... }" to disambiguate)',
	'math_CannotChangeDirectory'            => 'Cannot change working directory',
	'math_CannotCreateTexFile'              => 'Cannot create tex file',
	'math_CannotRunDvipng'                  => 'Cannot run dvipng',
	'math_CannotRunLatex'                   => 'Cannot run latex',
	'math_CannotWritePngDirectory'          => 'Cannot write to output PNG directory',
	'math_CannotWriteTexFile'               => 'Cannot write to tex file',
	'math_CasesRowTooBig'                   => 'There can only be two entries in each row of a "cases" block',
	'math_DoubleSubscript'                  => 'Encountered two subscripts attached to the same base (only one is allowed)',
	'math_DoubleSuperscript'                => 'Encountered two superscripts attached to the same base (only one is allowed)',
	'math_IllegalCharacter'                 => 'Illegal character in input',
	'math_IllegalCommandInMathMode'         => 'The command "$1" is illegal in math mode',
	'math_IllegalCommandInMathModeWithHint' => 'The command "$1" is illegal in math mode (perhaps you intended to use "$2" instead?)',
	'math_IllegalCommandInTextMode'         => 'The command "$1" is illegal in text mode',
	'math_IllegalCommandInTextModeWithHint' => 'The command "$1" is illegal in text mode (perhaps you intended to use "$2" instead?)',
	'math_IllegalDelimiter'                 => 'Illegal delimiter following "$1"',
	'math_IllegalFinalBackslash'            => 'Illegal backslash "\\" at end of input',
	'math_IllegalNestedFontEncodings'       => 'Font encoding commands may not be nested',
	'math_IllegalRedefinition'              => 'The command "$1" has already been defined; you cannot redefine it',
	'math_InvalidColour'                    => 'The colour "$1" is invalid',
	'math_InvalidUtf8Input'                 => 'The input string was not valid UTF-8',
	'math_LatexFontNotSpecified'            => 'No LaTeX font has been specified for "$1"',
	'math_LatexPackageUnavailable'          => 'Unable to render PNG because the LaTeX package "$1" is unavailable',
	'math_MismatchedBeginAndEnd'            => 'Commands "$1" and "$2" do not match',
	'math_MisplacedLimits'                  => 'The command "$1" can only appear after a math operator (consider using "\\mathop")',
	'math_MissingCommandAfterNewcommand'    => 'Missing or illegal new command name after "\\newcommand" (there must be precisely one command defined; it must begin with a backslash "\\" and contain only alphabetic characters)',
	'math_MissingDelimiter'                 => 'Missing delimiter after "$1"',
	'math_MissingOpenBraceAfter'            => 'Missing open brace "{" after "$1"',
	'math_MissingOpenBraceAtEnd'            => 'Missing open brace "{" at end of input',
	'math_MissingOpenBraceBefore'           => 'Missing open brace "{" before "$1"',
	'math_MissingOrIllegalParameterCount'   => 'Missing or illegal parameter count in definition of "$1" (must be a single digit between 1 and 9 inclusive)',
	'math_MissingOrIllegalParameterIndex'   => 'Missing or illegal parameter index in definition of "$1"',
	'math_NonAsciiInMathMode'               => 'Non-ASCII characters may only be used in text mode (try enclosing the problem characters in "\\text{...}")',
	'math_NotEnoughArguments'               => 'Not enough arguments were supplied for "$1"',
	'math_PngIncompatibleCharacter'         => 'Unable to correctly generate PNG containing the character $1',
	'math_ReservedCommand'                  => 'The command "$1" is reserved for internal use by blahtex',
	'math_SubstackRowTooBig'                => 'There can only be one entry in each row of a "substack" block',
	'math_TooManyMathmlNodes'               => 'There are too many nodes in the MathML tree',
	'math_TooManyTokens'                    => 'The input is too long',
	'math_UnavailableSymbolFontCombination' => 'The symbol "$1" is not available in the font "$2"',
	'math_UnexpectedNextCell'               => 'The command "&" may only appear inside a "\\begin ... \\end" block',
	'math_UnexpectedNextRow'                => 'The command "\\\\" may only appear inside a "\\begin ... \\end" block',
	'math_UnmatchedBegin'                   => 'Encountered "\\begin" without matching "\\end"',
	'math_UnmatchedCloseBrace'              => 'Encountered close brace "}" without matching open brace "{"',
	'math_UnmatchedEnd'                     => 'Encountered "\\end" without matching "\\begin"',
	'math_UnmatchedLeft'                    => 'Encountered "\\left" without matching "\\right"',
	'math_UnmatchedOpenBrace'               => 'Encountered open brace "{" without matching close brace "}"',
	'math_UnmatchedOpenBracket'             => 'Encountered open bracket "[" without matching close bracket "]"',
	'math_UnmatchedRight'                   => 'Encountered "\\right" without matching "\\left"',
	'math_UnrecognisedCommand'              => 'Unrecognised command "$1"',
	'math_WrongFontEncoding'                => 'The symbol "$1" may not appear in font encoding "$2"',
	'math_WrongFontEncodingWithHint'        => 'The symbol "$1" may not appear in font encoding "$2" (try using the "$3{...}" command)',
);

$messages['ar'] = array(
	'math_noblahtex'                        => 'لم يمكن تنفيذ بلاهتك، والتي ينبغي أن تكون في $1',
	'math_AmbiguousInfix'                   => 'وضع غير مريح ل"$1" (حاول استخدام أقواس إضافية "{ ... }" للتوضيح)',
	'math_CannotChangeDirectory'            => 'لا يمكن تغيير مجلد العمل',
	'math_CannotCreateTexFile'              => 'لا يمكن إنشاء ملف تك',
	'math_CannotRunDvipng'                  => 'لا يمكن تنفيذ dvipng',
	'math_CannotRunLatex'                   => 'لا يمكن تنفيذ لاتك',
	'math_CannotWritePngDirectory'          => 'لا يمكن الكتابة لمجلد PNG الخرج',
	'math_CannotWriteTexFile'               => 'لا يمكن الكتابة إلى ملف تك',
	'math_CasesRowTooBig'                   => 'يمكن فقط أن تكون هناك مدخلتان في كل صف في منع "حالات"',
	'math_DoubleSubscript'                  => 'صادف سكريبتين فرعيين مرتبطين بنفس القاعدة (فقط واحد مسموح به)',
	'math_DoubleSuperscript'                => 'صادف سكريبتين أعلى مرتبطين بنفس القاعدة (فقط واحد مسموح به)',
	'math_IllegalCharacter'                 => 'مدخل حروف غير قانوني',
	'math_IllegalCommandInMathMode'         => 'الأمر "$1" غير قانوني في نمط الرياضيات',
	'math_IllegalCommandInMathModeWithHint' => 'الأمر "$1" غير قانوني في نمط الرياضيات (ربما قصدت استخدام "$2" بدلا منه؟)',
	'math_IllegalCommandInTextMode'         => 'الأمر "$1" غير قانوني في نمط النص',
	'math_IllegalCommandInTextModeWithHint' => 'الأمر "$1" غير قانوني في نمط النص (ربما كنت تقصد استخدام "$2" بدلا منه؟)',
	'math_IllegalDelimiter'                 => 'delimiter غير قانوني يتبع "$1"',
	'math_IllegalFinalBackslash'            => 'فاصلة غي قانونية "\" في نهاية المدخل',
	'math_IllegalNestedFontEncodings'       => 'أوامر إنكودنج الخط لا ينبغي أن تكون نستد',
	'math_IllegalRedefinition'              => 'الأمر "$1" تم تعريفه بالفعل؛ لا يمكنك إعادة تعريفه',
	'math_InvalidColour'                    => 'اللون "$1" غير صحيح',
	'math_InvalidUtf8Input'                 => 'النص المدخل ليس UTF-8 صحيحا',
	'math_LatexFontNotSpecified'            => 'لا خط لاتك تم تحديده ل"$1"',
	'math_LatexPackageUnavailable'          => 'غير قادر على عرض PNG لأن رزمة لاتك "$1" غير متوفرة',
	'math_MismatchedBeginAndEnd'            => 'الأمران "$1" و "$2" لا يتطابقان',
	'math_MisplacedLimits'                  => 'الأمر "$1" يمكن أن يظهر فقط بعد عامل رياضيات (فكر في استخدام "\mathop")',
	'math_MissingCommandAfterNewcommand'    => 'اسم أمر جديد مفقود أو غير قانوني بعد "\newcommand" (يجب أن يكون هناك أمر واحد معرف بالضبط؛ يجب أن يبدأ بباك سلاش "\" ويحتوي فقط على حروف أبجدية)',
	'math_MissingDelimiter'                 => 'delimiter مفقود بعد "$1"',
	'math_MissingOpenBraceAfter'            => 'قوس مفتوح مفقود "{" بعد "$1"',
	'math_MissingOpenBraceAtEnd'            => 'قوس مفتوح مفقود "{" في نهاية المدخل',
	'math_MissingOpenBraceBefore'           => 'قوس مفتوح مفقود "{" قبل "$1"',
	'math_MissingOrIllegalParameterCount'   => 'عدد محددات مفقود أو غير قانوني "$1" (يجب أن يكون رقما وحيدا بين 1 و 9 حصريا)',
	'math_MissingOrIllegalParameterIndex'   => 'محدد فهرس مفقود أو غير قانوني في تعريف "$1"',
	'math_NonAsciiInMathMode'               => 'الحروف التي ليست ASCII يمكن أن تستخدم فقط في نمط النص (حاول إحاطة الحروف المشكلة في "\text{...}")',
	'math_NotEnoughArguments'               => 'لا محددات كافية تم توفيرها ل"$1"',
	'math_PngIncompatibleCharacter'         => 'غير قادر على توليد PNG يحتوي على الحرف $1 بطريقة صحيحة',
	'math_ReservedCommand'                  => 'الأمر "$1" محفوظ للاستخدام الداخلي بواسطة بلاهتك',
	'math_SubstackRowTooBig'                => 'يمكن أن يكون هناك مدخلة واحدة في كل صف من منع "سبستاك"',
	'math_TooManyMathmlNodes'               => 'توجد عقد كثيرة جدا في شجرة MathML',
	'math_TooManyTokens'                    => 'المدخل طويل جدا',
	'math_UnavailableSymbolFontCombination' => 'الرمز "$1" غير متوفر في الخط "$2"',
	'math_UnexpectedNextCell'               => 'الأمر "&" يمكن أن يظهر فقط بداخل منع "\begin ... \end"',
	'math_UnexpectedNextRow'                => 'الأمر "\\" يمكن أن يظهر فقط بداخل منع "\begin ... \end"',
	'math_UnmatchedBegin'                   => 'صادف "\begin" بدون "\end" مطابقة',
	'math_UnmatchedCloseBrace'              => 'صادف قوسا مغلقا "}" بدون قوس مفتوح مطابق "{"',
	'math_UnmatchedEnd'                     => 'صادف "\end" بدون "\begin" مطابقة',
	'math_UnmatchedLeft'                    => 'صادف "\left" بدون "\right" مطابقة',
	'math_UnmatchedOpenBrace'               => 'صادف قوسا مفتوحا "{" بدون قوس مغلق مطابق "}"',
	'math_UnmatchedOpenBracket'             => 'صادف قوسا مفتوحا "[" بدون قوس مغلق مطابق "]"',
	'math_UnmatchedRight'                   => 'صادف "\right" بدون "\left" مطابقة',
	'math_UnrecognisedCommand'              => 'أمر غير متعرف عليه "$1"',
	'math_WrongFontEncoding'                => 'الرمز "$1" ربما لا يظهر في إنكودنج الخط "$2"',
	'math_WrongFontEncodingWithHint'        => 'الرمز "$1" ربما لا يظهر في إنكودنج الخط "$2" (حاول استخدام أمر "$3{...}")',
);

$messages['fr'] = array(
	'math_noblahtex'                        => 'Ne peut exécuter blahtex, qui devrait être à $1',
	'math_AmbiguousInfix'                   => 'La position de « $1 » est ambigue (ajouter des balises additionnelles « { ... } » peut lever l\'ambiguité)',
	'math_CannotChangeDirectory'            => 'Ne peut changer de dossier de travail',
	'math_CannotCreateTexFile'              => 'Ne peut créer un fichier tex',
	'math_CannotRunDvipng'                  => 'Ne peut exécuter dvipng',
	'math_CannotRunLatex'                   => 'Ne peut exécuter LaTeX',
	'math_CannotWritePngDirectory'          => 'Ne peut écrire dans le dossier des fichiers PNG',
	'math_CannotWriteTexFile'               => 'Ne peut écrire dans un fichier tex',
	'math_CasesRowTooBig'                   => 'Il ne peut y avoir que deux entrées dans chaque rangée d\'un bloc « cases ».',
	'math_DoubleSubscript'                  => 'Deux indices sont rattachés à la même base, un seul est permis.',
	'math_DoubleSuperscript'                => 'Deux exposants sont rattachés à la même base, un seul est permis.',
	'math_IllegalCharacter'                 => 'Caractère interdit dans la donnée saisie',
	'math_IllegalCommandInMathMode'         => 'La commande « $1 » est interdite en mode math.',
	'math_IllegalCommandInMathModeWithHint' => 'La commande « $1 » est interdite en mode math (peut-être vouliez-vous utiliser « $2 » à la place ?)',
	'math_IllegalCommandInTextMode'         => 'La commande « $1 » est interdite en mode texte.',
	'math_IllegalCommandInTextModeWithHint' => 'La commande « $1 » est interdite en mode texte (peut-être vouliez-vous utiliser « $2 » à la place ?)',
	'math_IllegalDelimiter'                 => 'Délimiteur interdit après « $1 »',
	'math_IllegalFinalBackslash'            => 'Le caractère « \ » ne peut apparaître à la fin de la saisie.',
	'math_IllegalNestedFontEncodings'       => 'Les commandes d\'encodage de caractères ne peuvent être imbriquées.',
	'math_IllegalRedefinition'              => 'La commande « $1 » est déjà définie, vous ne pouvez la redéfinir.',
	'math_InvalidColour'                    => 'La couleur « $1 » n\'est pas valide.',
	'math_InvalidUtf8Input'                 => 'La chaîne de caractères saisie n\'est pas au format UTF-8.',
	'math_LatexFontNotSpecified'            => 'Aucune police de caractères LaTeX n\'a été précisée pour « $1 ».',
	'math_LatexPackageUnavailable'          => 'Ne peut rendre le fichier PNG car le paquetage LaTeX « $1 » n\'est pas accessible.',
	'math_MismatchedBeginAndEnd'            => 'Les commandes « $1 » et « $2 » ne correspondent pas.',
	'math_MisplacedLimits'                  => 'La commande « $1 » doit apparaître après un opérateur lorsqu\'en mode math (suggestion : essayez « mathop »).',
	'math_MissingCommandAfterNewcommand'    => 'Un nouveau nom de commande est manquant ou fautif après « \newcommand » (il doit y avoir précisément une commande définie, elle doit commencer par « \ » et ne contenir que des caractères alphabétique).',
	'math_MissingDelimiter'                 => 'Un délimiteur manque après « $1 ».',
	'math_MissingOpenBraceAfter'            => 'La balise « { » manque après « $1 »',
	'math_MissingOpenBraceAtEnd'            => 'La balise « { » manque à la fin de la saisie.',
	'math_MissingOpenBraceBefore'           => 'La balise « { » manque avant « $1 »',
	'math_MissingOrIllegalParameterCount'   => 'Décompte de paramètre manquant ou fautif dans la définition de « $1 » (doit être un seul chiffre compris entre 1 et 9 inclusivement)',
	'math_MissingOrIllegalParameterIndex'   => 'Index de paramètre manquant ou fautif dans la définition de « $1 »',
	'math_NonAsciiInMathMode'               => 'Les caractères hors ASCII peuvent seulement être utilisés en mode texte (essayez de mettre les caractères problématiques dans « \text{...} »).',
	'math_NotEnoughArguments'               => 'Pas assez d\'arguments saisis pour « $1 »',
	'math_PngIncompatibleCharacter'         => 'Ne peut générer le fichier PNG qui contient le caractère $1.',
	'math_ReservedCommand'                  => 'La commande « $1 » est réservée à blahtex.',
	'math_SubstackRowTooBig'                => 'Il ne peut y avoir qu\'une seule entrée dans chaque rangée d\'un bloc « sous-pilé ».',
	'math_TooManyMathmlNodes'               => 'Il y a trop de noeuds dans l\'arbre MathML.',
	'math_TooManyTokens'                    => 'La donnée saisie est trop longue.',
	'math_UnavailableSymbolFontCombination' => 'Le symbole « $1 » n\'est pas disponible pour la police de caractères « $2 ».',
	'math_UnexpectedNextCell'               => 'La commande « & » peut seulement apparaître dans un bloc « \begin ... \end ».',
	'math_UnexpectedNextRow'                => 'La commande « \\ » peut seulement apparaître dans un bloc « \begin ... \end ».',
	'math_UnmatchedBegin'                   => 'La balise « \begin » n\'est pas balancée par la balise « \end ».',
	'math_UnmatchedCloseBrace'              => 'La balise « } » n\'est pas précédée par la balise « { ».',
	'math_UnmatchedEnd'                     => 'La balise « \end » n\'est pas précédée par la balise « \begin ».',
	'math_UnmatchedLeft'                    => 'La balise « \left » n\'est pas balancée par la balise « \right ».',
	'math_UnmatchedOpenBrace'               => 'La balise « { » n\'est pas balancée par la balise « } ».',
	'math_UnmatchedOpenBracket'             => 'La balise « [ » n\'est pas balancée par la balise « ] ».',
	'math_UnmatchedRight'                   => 'La balise « \right » n\'est pas balancée par la balise « \left ».',
	'math_UnrecognisedCommand'              => 'Commande inconnue « $1 »',
	'math_WrongFontEncoding'                => 'Le symbole « $1 » peut ne pas apparaître dans l\'encodage de caractères « $2 ».',
	'math_WrongFontEncodingWithHint'        => 'Le symbole « $1 » pourrait ne pas être affiché par l\'encodage de caractères « $2 » (essayez la commande « $3{...} »).',
);

$messages['hsb'] = array(
	'math_noblahtex'                        => 'Njeje móžno blahtex wuwjesć, kotryž měł pola $1 być',
	'math_AmbiguousInfix'                   => 'Wjacezmyslne zaměstnjenje "$1" (spytaj přidatne zhibowane spinki wužiwać "{ ... }", zo by jednozmyslnosć wutworił)',
	'math_CannotChangeDirectory'            => 'Dźěłowy zapis njeda so změnić',
	'math_CannotCreateTexFile'              => 'Njeje móžno tex-dataju wutworić',
	'math_CannotRunDvipng'                  => 'dvipng njeda so startować',
	'math_CannotRunLatex'                   => 'latex njeda so startować',
	'math_CannotWritePngDirectory'          => 'Wudaće njeda so do zapisa PNG pisać',
	'math_CannotWriteTexFile'               => 'Njeje móžno do tex-dataje pisać',
	'math_CasesRowTooBig'                   => 'Smětej jenož dwaj zapiskaj w kóždej rjadce bloka "cases" być',
	'math_DoubleSubscript'                  => 'Namakaštej so dwaj indeksaj pola samsneje bazy (jenož jedyn je dowoleny)',
	'math_DoubleSuperscript'                => 'Namakaštej so dwaj eksponentaj pola samsneje bazy (jenož jedyn je dowoleny)',
	'math_IllegalCharacter'                 => 'Njedowolene znamješko w zapodaću',
	'math_IllegalCommandInMathMode'         => 'Přikaz "$1" njeje w modusu math dowoleny.',
	'math_IllegalCommandInMathModeWithHint' => 'Přikaz "$1" njeje w modusu math dowoleny (chcyše ty snano město toho "$2" wužiwać?)',
	'math_IllegalCommandInTextMode'         => 'Přikaz "$1" njeje w tekstowym modusu dowoleny',
	'math_IllegalCommandInTextModeWithHint' => 'Přikaz "$1" njeje w tekstowym modusu dowoleny (chcyše ty snano město toho "$2" wužiwać?)',
	'math_IllegalDelimiter'                 => 'Njedowolene dźělatko zady "$1"',
	'math_IllegalFinalBackslash'            => 'Njedowolena wróćosmužka "\" na kóncu zapodaća',
	'math_IllegalNestedFontEncodings'       => 'Pismokodowanske přikazy njehodźa so zakašćikować',
	'math_IllegalRedefinition'              => 'Přikaz "$1" je so hižo definował; njemóžeš jón znowa definować',
	'math_InvalidColour'                    => 'Barba "$1" je njepłaćiwa',
	'math_InvalidUtf8Input'                 => 'Zapodaty znamješkowy rjećazk njeje w płaćiwym UTF-8',
	'math_LatexFontNotSpecified'            => 'Žane pismo LaTeX njebu za "$1" podane',
	'math_LatexPackageUnavailable'          => 'Njemóžno PNG předźěłać, dokelž pakćik "$1" za LaTeX k dispoziciji njesteji',
	'math_MismatchedBeginAndEnd'            => 'Přikazaj "$1" a "$2" njekryjetej so',
	'math_MisplacedLimits'                  => 'Přikaz "$1" móže so jenož za operatorom math jewić (rozpomń wužiwanje přikaza "\mathop")',
	'math_MissingCommandAfterNewcommand'    => 'Falowace abo njedowolene přikazowe mjeno za přikazom "\newcommand" (dyrbi eksaktnje jedyn přikaz definowany być; dyrbi so z wróćosmužku "\" započeć a smě jenož alfabetiske znamješka wobsahować)',
	'math_MissingDelimiter'                 => 'Dźělatko zady "$1" faluje',
	'math_MissingOpenBraceAfter'            => 'Spočatna zhibowana spinka "{" za "$1" faluje',
	'math_MissingOpenBraceAtEnd'            => 'Spočatna zhibowana spinka "{" na kóncu zapodaća faluje',
	'math_MissingOpenBraceBefore'           => 'Spočatna zhibowana spinka "{" před "$1" faluje',
	'math_MissingOrIllegalParameterCount'   => 'Falowace abo njedowolene parametrowe ličenje w definiciji "$1"  (dyrbi cyfra mjez 1 a inkluziwnje 9 być)',
	'math_MissingOrIllegalParameterIndex'   => 'Falowacy abo njedowoleny parametrowy indeks w definiciji "$1"',
	'math_NonAsciiInMathMode'               => 'Znamješka nje-ASCII smědźa so jenož w tekstowym modusu wužiwać (spytaj problematiske znamješka w "\text{...}" zapřijeć)',
	'math_NotEnoughArguments'               => 'Nic dosć argumentow za "$1" dodate',
	'math_PngIncompatibleCharacter'         => 'Njemóžno PNG ze znamješkom $1 korektnje płodźić',
	'math_ReservedCommand'                  => 'Přikaz "$1" je za interne wužiwanje přez blahtex rezerwowany',
	'math_SubstackRowTooBig'                => 'Smě jenož jedyn zapisk w kóždej rjadce bloka "substack" być',
	'math_TooManyMathmlNodes'               => 'Je přewjele sukow w štomje MathML',
	'math_TooManyTokens'                    => 'Zapodaće je předołho.',
	'math_UnavailableSymbolFontCombination' => 'Symbol "$1" w pismje "$2" k dispoziciji njesteji',
	'math_UnexpectedNextCell'               => 'Přikaz "&" smě so jenož znutřka bloka "\begin ... \end" jewić',
	'math_UnexpectedNextRow'                => 'Přikaz "\\" smě so jenož znutřka bloka "\begin ... \end" jewić',
	'math_UnmatchedBegin'                   => '"\begin" bjez přisłušneho "\end" namakany',
	'math_UnmatchedCloseBrace'              => 'Kónčna zhibowana spinka "}" bjez přisłušneje spočatneje zhibowaneje spinki "{" namakana',
	'math_UnmatchedEnd'                     => '"\end" bjez přisłušneho "\begin" namakany',
	'math_UnmatchedLeft'                    => '"\left" bjez přisłušneho "\right" namakany',
	'math_UnmatchedOpenBrace'               => 'Spočatna zhibowana spinka "{" bjez přisłušneje kónčneje spinki "}" namakana',
	'math_UnmatchedOpenBracket'             => 'Spočatna róžkata spinka "[" bjez přisłušneje kónčneje róžkateje spinki "]" namakana',
	'math_UnmatchedRight'                   => '"\right" bjez přisłušneho "\left" namakany',
	'math_UnrecognisedCommand'              => 'Njespóznaty přikaz "$1"',
	'math_WrongFontEncoding'                => 'Symbol "$1" njesmě so w pismowym kodowanju "$2" jewić',
	'math_WrongFontEncodingWithHint'        => 'Symbol "$1" njesmě so w pismowym kodowanju "$2" jewić (spytaj přikaz "$3{...}" wužiwać)',
);

$messages['nl'] = array(
	'math_CannotCreateTexFile'              => 'Kan geen tex-bestand aanmaken',
	'math_IllegalCharacter'                 => 'Ongeldig teken in de invoer',
	'math_InvalidColour'                    => 'De kleur "$1" is ongeldig',
	'math_InvalidUtf8Input'                 => 'De invoertekst was geen geldig UTF-8',
	'math_MismatchedBeginAndEnd'            => 'Bevelen "$1" en "$1" komen niet overeen',
	'math_ReservedCommand'                  => 'Het bevel "$1" is gereserveerd voor intern gebruik door blahtex',
	'math_TooManyTokens'                    => 'De invoer is te lang',
	'math_UnrecognisedCommand'              => 'Onherkend bevel "$1"',
);

$messages['pt'] = array(
	'math_noblahtex'                        => 'Não é possível executar blahtex, que deveria estar em $1',
	'math_AmbiguousInfix'                   => 'Posicionamento ambígua de "$1" (experimente usar chavetas adicionais "{ ... }" para desfazer a ambiguidade)',
	'math_CannotRunLatex'                   => 'Não é possível executar latex',
	'math_IllegalCharacter'                 => 'Caracter inválido nos dados introduzidos',
	'math_IllegalCommandInMathMode'         => 'O comando "$1" é inválido em modo matemático',
	'math_IllegalCommandInMathModeWithHint' => 'O comando "$1" é inválido em modo matemático (talvez pretendesse usar "$2"?)',
	'math_IllegalCommandInTextMode'         => 'O comando "$1" é inválido em modo de texto',
	'math_IllegalCommandInTextModeWithHint' => 'O comando "$1" é inválido em modo de texto (talvez pretendesse usar "$2"?)',
	'math_IllegalDelimiter'                 => 'Delimitador inválido após "$1"',
	'math_IllegalFinalBackslash'            => 'Barra inversa "\" inválida no fim dos dados introduzidos',
	'math_IllegalNestedFontEncodings'       => 'Comandos de codificação de tipo de letra não podem ser encapsulados uns nos outros',
	'math_InvalidColour'                    => 'A cor "$1" é inválida',
	'math_InvalidUtf8Input'                 => 'O texto introduzido não é UTF-8 válido',
	'math_LatexFontNotSpecified'            => 'Nenhum tipo de letra LaTeX foi especificado para "$1"',
	'math_MissingDelimiter'                 => 'Falta delimitador depois de "$1"',
	'math_MissingOpenBraceAfter'            => 'Falta chaveta de abertura "{" depois de "$1"',
	'math_MissingOpenBraceAtEnd'            => 'Falta chaveta de abertura "{" no fim do texto introduzido',
	'math_MissingOpenBraceBefore'           => 'Falta chaveta de abertura "{" antes de "$1"',
	'math_TooManyTokens'                    => 'O texto introduzido é demasiado longo',
	'math_UnavailableSymbolFontCombination' => 'O símbolo "$1" não está disponível no tipo de letra "$2"',
	'math_UnrecognisedCommand'              => 'Comando "$1" não reconhecido',
	'math_WrongFontEncoding'                => 'O símbolo "$1" não pode aparecer na codificação de tipo de letra "$2"',
	'math_WrongFontEncodingWithHint'        => 'O símbolo "$1" não pode aparecer na codificação de tipo de letra "$2" (experimente usar o comando "$3{...}")',
);

$messages['ro'] = array(
	'math_noblahtex'                        => 'Nu se poate executa blahtex, care ar trebui să fie la $1',
	'math_AmbiguousInfix'                   => 'Amplasare ambiguă pentru "$1" (încercaţi folosirea acoladelor "{ ... }" pentru dezambiguizare)',
	'math_CannotChangeDirectory'            => 'Nu se poate schmba directorul în lucru',
	'math_CannotCreateTexFile'              => 'Nu se poate crea fişierul tex',
	'math_CannotRunDvipng'                  => 'Nu se poate rula dvipng',
	'math_CannotRunLatex'                   => 'Nu se poate rula latex',
	'math_CannotWritePngDirectory'          => 'Nu se poate scrie în directorul PNG de ieşire',
	'math_CannotWriteTexFile'               => 'Nu se poate scrie fişierul tex',
	'math_CasesRowTooBig'                   => 'Pot exista doar două intrări pe fiecare rând al unui bloc "cases"',
	'math_DoubleSubscript'                  => 'S-au găsit doi indici pentru aceeaşi bază (numai unul este permis)',
	'math_DoubleSuperscript'                => 'S-au găsit doi exponenţi pentru aceeaşi bază (numai unul este permis)',
	'math_IllegalCharacter'                 => 'Caracter nepermis introdus',
	'math_IllegalCommandInMathMode'         => 'Comanda "$1" nu este permisă în modul math',
	'math_IllegalCommandInMathModeWithHint' => 'Comanda "$1" nu este permisă în modul math (doreaţi să folosiţi "$2" în loc?)',
	'math_IllegalCommandInTextMode'         => 'Comanda "$1" nu este permisă în modul text',
	'math_IllegalCommandInTextModeWithHint' => 'Comanda "$1" nu este permisă în modul text (doreaţi să folosiţi "$2" în loc?)',
	'math_IllegalDelimiter'                 => 'Delimitator nepermis după "$1"',
	'math_IllegalFinalBackslash'            => 'Backslash "\" nepermis la sfârşitul intrării',
	'math_IllegalNestedFontEncodings'       => 'Comenzile de codare a fontului nu pot fi imbricate',
	'math_IllegalRedefinition'              => 'Comanda "$1" a fost deja definită; nu o puteţi redefini',
	'math_InvalidColour'                    => 'Culoarea "$1" nu este validă',
	'math_InvalidUtf8Input'                 => 'Şirul de intrare nu a fost valid UTF-8',
	'math_LatexFontNotSpecified'            => 'Nici un font LaTeX nu a fost specificat pentru "$1"',
	'math_LatexPackageUnavailable'          => 'Nu se poate reda ca PNG deoarece pachetul "$1" LaTeX nu este disponibil',
	'math_MismatchedBeginAndEnd'            => 'Comenzile "$1" şi "$2" nu se potrivesc',
	'math_MisplacedLimits'                  => 'Comanda "$1" poate apărea doar după un operator math (utilizaţi "\mathop")',
	'math_MissingCommandAfterNewcommand'    => 'Nume de comandă lipsă sau nepermis după "\newcommand" (trebuie să fie exact o comandă definită; trebuie să înceapă cu un backslash "\" şi să conţină doar caractere alfabetice)',
	'math_MissingDelimiter'                 => 'Delimitator lipsă după "$1"',
	'math_MissingOpenBraceAfter'            => 'Acoladă deschisă "{" lipsă după "$1"',
	'math_MissingOpenBraceAtEnd'            => 'Acoladă deschisă "{" lipsă la sfârşitul intrării',
	'math_MissingOpenBraceBefore'           => 'Acoladă dechisă "{" lipsă înainte de "$1"',
	'math_MissingOrIllegalParameterCount'   => 'Număr de parametri lipsă sau nepermis în definiţia pentru "$1" (trebuie să fie doar o cifră între 1 şi 9 inclusiv)',
	'math_MissingOrIllegalParameterIndex'   => 'Index de parametri lipsă sau nepermis în definiţia pentru "$1"',
	'math_NonAsciiInMathMode'               => 'Caracterele non-ASCII pot fi folosite doar în modul text (încercaţi imbricarea caracterelor problemă în "\text{...}")',
	'math_NotEnoughArguments'               => 'Număr insuficient de argumente pentru "$1"',
	'math_PngIncompatibleCharacter'         => 'Imposibil de generat PNG corect conţinând caracterul $1',
	'math_ReservedCommand'                  => 'Comanda "$1" este rezervată pentru uz intern de către blahtex',
	'math_SubstackRowTooBig'                => 'Poate exista doar o intrare pe fiecare rând al unui bloc "substack"',
	'math_TooManyMathmlNodes'               => 'Sunt prea multe noduri în arborele MathML',
	'math_TooManyTokens'                    => 'Intrarea este prea lungă',
	'math_UnavailableSymbolFontCombination' => 'Simbolul "$1" nu este disponibil în fontul "$2"',
	'math_UnexpectedNextCell'               => 'Comanda "&" poate apărea doar în interiorul unui bloc "\begin ... \end"',
	'math_UnexpectedNextRow'                => 'Comanda "\\" poate apărea doar în interiorul unui bloc "\begin ... \end"',
	'math_UnmatchedBegin'                   => 'S-a găsit "\begin" fără "\end" corespunzător',
	'math_UnmatchedCloseBrace'              => 'S-a găsit acoladă închisă "}" fără acoladă deschisă "{" corespunzătoare',
	'math_UnmatchedEnd'                     => 'S-a găsit "\end" fără "\begin" corespunzător',
	'math_UnmatchedLeft'                    => 'S-a găsit "\left" fără "\right" corespunzător',
	'math_UnmatchedOpenBrace'               => 'S-a găsit acoladă deschisă "}" fără acoladă închisă "{" corespunzătoare',
	'math_UnmatchedOpenBracket'             => 'S-a găsit paranteză pătrată deschisă "[" fără paranteză pătrată închisă "]" corespunzătoare',
	'math_UnmatchedRight'                   => 'S-a găsit "\right" fără "\left" corespunzător',
	'math_UnrecognisedCommand'              => 'Comanda "$1" necunoscută',
	'math_WrongFontEncoding'                => 'Simbolul "$1" nu poate apărea în fontul "$2"',
	'math_WrongFontEncodingWithHint'        => 'Simbolul "$1" nu poate apărea în fontul "$2" (încercaţi să folosiţi comanda "$3{...}")',
);
