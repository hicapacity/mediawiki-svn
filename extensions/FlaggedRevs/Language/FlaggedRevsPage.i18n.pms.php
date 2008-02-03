<?php
/** Piemontèis (Piemontèis)
 * @author Bèrto 'd Sèra
 * @author Siebrand
 * @author SPQRobin
 */
$messages = array(
	'editor'                      => 'Redator',
	'group-editor'                => 'Redator',
	'group-editor-member'         => 'Redator',
	'grouppage-editor'            => '{{ns:project}}:Redator',
	'reviewer'                    => 'Revisor',
	'group-reviewer'              => 'Revisor',
	'group-reviewer-member'       => 'Revisor',
	'grouppage-reviewer'          => '{{ns:project}}:Revisor',
	'revreview-current'           => 'Version corenta',
	'tooltip-ca-current'          => 'Vardé la bruta corenta dë sta pàgina-sì',
	'revreview-edit'              => 'Modifiché la bruta',
	'revreview-source'            => 'sorgiss dla bruta',
	'revreview-stable'            => 'Version stàbila',
	'tooltip-ca-stable'           => 'Vardé la version stàbila dla pàgina',
	'revreview-oldrating'         => "A l'é stait giudicà për:",
	'revreview-noflagged'         => "A-i é pa gnun-a version revisionà dë sta pàgina-sì, donca a l'é belfé ch'a la sia '''nen''' staita
	[[{{MediaWiki:Validationpage}}|controlà]] coma qualità.",
	'stabilization-tab'           => '(c.q.)',
	'tooltip-ca-default'          => 'Regolassion dij Contròj ëd Qualità',
	'revreview-quick-none'        => "'''Corenta'''. Pa gnun-a version revisionà.",
	'revreview-quick-see-quality' => "'''Corenta'''. [{{fullurl:{{FULLPAGENAMEE}}|stable=1}} ùltima version votà për qualità]",
	'revreview-quick-see-basic'   => "'''Corenta'''. [{{fullurl:{{FULLPAGENAMEE}}|stable=1}} ùltima version vardà]",
	'revreview-quick-basic'       => "'''[[{{MediaWiki:Validationpage}}|Vardà]]'''. [{{fullurl:{{FULLPAGENAMEE}}|stable=0}} version corenta] 
	($2 [{{fullurl:{{FULLPAGENAMEE}}|oldid=$1&diff=cur}} {{plural:$2|modìfica|modìfiche}}])",
	'revreview-quick-quality'     => "'''[[{{MediaWiki:Validationpage}}|Qualità]]'''. [{{fullurl:{{FULLPAGENAMEE}}|stable=0}} version corenta] 
	($2 [{{fullurl:{{FULLPAGENAMEE}}|oldid=$1&diff=cur}} {{plural:$2|modìfica|modìfiche}}])",
	'revreview-newest-basic'      => "L'[{{fullurl:{{FULLPAGENAMEE}}|stable=1}} ùltima version vardà] 
	([{{fullurl:Special:Stableversions|page={{FULLPAGENAMEE}}}} vardeje tute]) dë sta pàgina-sì a l'é staita [{{fullurl:Special:Log|type=review&page={{FULLPAGENAMEE}}}} aprovà]
	 dël <i>$2</i>. <br/> A-i {{plural:$3|é|son}} $3 version ([{{fullurl:{{FULLPAGENAMEE}}|oldid=$1&diff=cur}} modìfiche]) ch'a speto na revision.",
	'revreview-newest-quality'    => "L'[{{fullurl:{{FULLPAGENAMEE}}|stable=1}} ùltim vot ëd qualità] 
	([{{fullurl:Special:Stableversions|page={{FULLPAGENAMEE}}}} vardeje tuti]) dë sta pàgina-sì a l'é stait [{{fullurl:Special:Log|type=review&page={{FULLPAGENAMEE}}}} aprovà]
	 dël <i>$2</i>. <br/> A-i {{plural:$3|é|son}} $3 version ([{{fullurl:{{FULLPAGENAMEE}}|oldid=$1&diff=cur}} modìfiche]) ch'a speto d'esse revisionà.",
	'revreview-basic'             => "Costa-sì a l'é l'ùltima version [[{{MediaWiki:Validationpage}}|vardà]] dla pàgina, 
	[{{fullurl:Special:Log|type=review&page={{FULLPAGENAMEE}}}} aprovà] dël <i>$2</i>. La [{{fullurl:{{FULLPAGENAMEE}}|stable=0}} version corenta] 
	për sòlit as peul [{{fullurl:{{FULLPAGENAMEE}}|action=edit}} modifichesse] e a l'é pì agiornà. A-i {{plural:$3|é $3 revision|son $3 version}} 
	([{{fullurl:{{FULLPAGENAMEE}}|oldid=$1&diff=cur}} modìfiche]) ch'a speto d'esse vardà.",
	'revreview-quality'           => "Costa-sì a l'é l'ùltima revision ëd [[{{MediaWiki:Validationpage}}|qualità]] dë sta pàgina, e a l'é staita
	[{{fullurl:Special:Log|type=review&page={{FULLPAGENAMEE}}}} aprovà] dël <i>$2</i>. La [{{fullurl:{{FULLPAGENAMEE}}|stable=0}} version corenta] 
	për sòlit as peul [{{fullurl:{{FULLPAGENAMEE}}|action=edit}} modifichesse] e a l'é pì agiornà. A-i {{plural:$3|é|son}} $3 version 
	([{{fullurl:{{FULLPAGENAMEE}}|oldid=$1&diff=cur}} modìfiche]) da revisioné.",
	'revreview-static'            => "Costa a l'é na version [[{{MediaWiki:Validationpage}}|revisionà]] dë '''[[:$3|sta pàgina]]''', 
	[{{fullurl:Special:Log/review|page=$1}} aprovà] dij <i>$2</i>. La [{{fullurl:$3|stable=0}} version corenta] 
	për sòlit as peul modifichesse e a l'é pì agiornà.",
	'revreview-toggle'            => '(visca/dësmòrta ij detaj)',
	'revreview-note'              => "[[User:$1]] a l'ha buta-ie ste nòte-sì a la revision, antramentr ch'a la [[{{MediaWiki:Validationpage}}|controlava]]:",
	'revreview-update'            => "Për piasì, ch'a contròla le modìfiche (smonùe ambelessì sota) faite da quand a l'é staita publicà la revision stàbila dla pàgina. A son stait modificà ëdcò jë stamp e le figure smonùe ambelessì dapress:",
	'revreview-update-none'       => "Për piasì, ch'a contròla le modìfiche (smonùe ambelessì sota) faite da quand a l'é staita publicà la revision stàbila dla pàgina.",
	'revreview-auto'              => '(aotomàtich)',
	'revreview-auto-w'            => "A l'é antramentr ch'a-i fa dle modìfiche ansima a la version stàbila, tute le modìfiche a saran '''controlà n<nowiki>'</nowiki>aotomàtich'''. A peul ëvnì a taj vardé na preuva dla pàgina anans che fé che salvé.",
	'revreview-auto-w-old'        => "A l'é antramentr ch'a-i fa dle modìfiche ansima a na revision veja, tute le modìfiche a saran '''controlà n<nowiki>'</nowiki>aotomàtich'''. A peul ëvnì a taj vardé na preuva dla pàgina anans che fé che salvé.",
	'hist-stable'                 => '[vardà]',
	'hist-quality'                => '[qualità]',
	'flaggedrevs'                 => 'Revision marcà',
	'review-logpage'              => "Registr dij contròj dj'artìcoj",
	'review-logpagetext'          => "Sossì a l'é un registr dle modìfiche dlë stat d'[[{{MediaWiki:Makevalidate-page}}|aprovassion]] 
	dle pàgine ëd contnù.",
	'review-logentry-app'         => 'controlà [[$1]]',
	'review-logentry-dis'         => 'depressà na version ëd [[$1]]',
	'review-logaction'            => 'Nùmer ëd revision $1',
	'stable-logpage'              => 'Registr dle version stàbij',
	'stable-logpagetext'          => "Cost-sì a l'é un registr dle modìfiche faite a la regolassion dla [[{{MediaWiki:Validationpage}}|version stàbil]] dle pàgine ëd contnù.",
	'stable-logentry'             => 'regolà la version stàbila ëd [[$1]]',
	'stable-logentry2'            => 'azerà la version stàbila për [[$1]]',
	'revisionreview'              => 'Revisioné le version',
	'revreview-main'              => "Për podej revisioné a venta ch'as selession-a na version ëd na pàgina ëd contnù. 

	Ch'a varda [[Special:Unreviewedpages|da revisioné]] për na lista ëd pàgine ch'a speto na revision.",
	'revreview-selected'          => "Version selessionà ëd '''$1:'''",
	'revreview-text'              => "Për sòlit pitòst che nen j'ùltime, as ësmon-o për contnù le version stàbij.",
	'revreview-toolow'            => 'A venta ch\'a buta tuti j\'atribut ambelessì sota almanch pì àot che "pa aprovà" përché
	na version ës conta da revisionà. Për dëspresié na version ch\'a-i buta tuti ij camp a "pa aprovà".',
	'revreview-flag'              => 'Revisioné sta version',
	'revreview-legend'            => "Deje 'l vot al contnù dla version:",
	'revreview-notes'             => 'Osservation ò nòte da smon-e:',
	'revreview-accuracy'          => 'Cura',
	'revreview-accuracy-0'        => 'Pa aprovà',
	'revreview-accuracy-1'        => 'Vardà',
	'revreview-accuracy-2'        => 'Curà',
	'revreview-accuracy-3'        => 'Bon-e sorgiss',
	'revreview-accuracy-4'        => 'Premià',
	'revreview-depth'             => 'Ancreus',
	'revreview-depth-0'           => 'Pa aprovà',
	'revreview-depth-1'           => 'Mìnim',
	'revreview-depth-2'           => 'Mes',
	'revreview-depth-3'           => 'Bon',
	'revreview-depth-4'           => 'Premià',
	'revreview-style'             => 'Belfé da lese',
	'revreview-style-0'           => 'Pa aprovà',
	'revreview-style-1'           => 'A peul andé',
	'revreview-style-2'           => 'Bon-a',
	'revreview-style-3'           => 'Concisa',
	'revreview-style-4'           => 'Premià',
	'revreview-log'               => 'Coment për ël registr:',
	'revreview-submit'            => 'Buta la revision',
	'revreview-changed'           => "'''L'arcesta a l'é nen podusse sodisfé për lòn ch'a toca sta revision-sì.'''
	
	A puel esse ch'a sia ciamasse në stamp ò na figura sensa ch'a fussa butasse la version. Sòn a peul rivé quand në 
	stamp dinàmich a transclud na figura ò n'àotr ëstamp conforma a na variàbil dont contnù a peul esse cambià da  
	quand a l'ha anandiasse a vardé sta pàgina-sì. Carié torna la pàgina e anandiesse da zero a peul arsolve la gran-a.",
	'stableversions'              => 'Version stàbij',
	'stableversions-leg1'         => 'Fé na lista dle version aprovà ëd na pàgina',
	'stableversions-page'         => 'Nòm dla pàgina',
	'stableversions-none'         => "[[:$1]] a l'ha pa gnun-a version revisionà.",
	'stableversions-list'         => "Costa-sì a l'é na lista ëd version ëd [[:$1]] ch'a son ëstaite revisionà:",
	'stableversions-review'       => 'Revisionà dël <i>$1</i>',
	'review-diff2stable'          => "Diferensa da 'nt l'ùltima version stàbila",
	'unreviewedpages'             => 'Pàgine dësrevisionà',
	'viewunreviewed'              => "Lista dle pàgine ëd contnù ch'a son ëstaite dësrevisionà",
	'unreviewed-outdated'         => "Smon cole pàgine ch'a l'han dle version nen controlà faite ansima a la version stàbila.",
	'unreviewed-category'         => 'Categorìa:',
	'unreviewed-diff'             => 'Modìfiche',
	'unreviewed-list'             => "Costa-sì a l'é na lista d'artìcoj ch'a son anco' pa stait revisionà.",
	'revreview-visibility'        => "Sta pàgina-sì a l'ha na [[{{MediaWiki:Validationpage}}|version stàbila]], ch'as peul [{{fullurl:Special:Stabilization|page={{FULLPAGENAMEE}}}} regolesse].",
	'stabilization'               => 'Stabilisassion dla pàgina',
	'stabilization-text'          => "Ch'a toca le regolassion ambelessì sota për rangé coma la version stàbila ëd [[:$1|$1]] a debia esse sërnùa e smonùa.",
	'stabilization-perm'          => "Sò cont a l'ha pa ij përmess dont a fa da manca për toché le regolassion dla version stàbila. Ambelessì a-i son le regolassion corente për [[:$1|$1]]:",
	'stabilization-page'          => 'Nòm dla pàgina:',
	'stabilization-leg'           => 'Regolé la version stàbila ëd na pàgina',
	'stabilization-select'        => 'Coma sërne la version stàbila',
	'stabilization-select1'       => "Ùltima revision ëd qualità; s'a-i é nen cola, pijé l'ùltima controlà",
	'stabilization-select2'       => 'Ùltima revision controlà',
	'stabilization-def'           => 'Revision da smon-e coma pàgina sòlita për la vos',
	'stabilization-def1'          => "la version stàbila, s'a-i n'a-i é gnun-a, pijé cola corenta",
	'stabilization-def2'          => 'la revision corenta',
	'stabilization-submit'        => 'Confermé',
	'stabilization-notexists'     => 'A-i é pa gnun-a pàgina ch\'as ciama "[[:$1|$1]]". As peul nen regolé lòn ch\'a-i é nen.',
	'stabilization-notcontent'    => 'La pàgina "[[:$1|$1]]" as peul pa s-ciairesse. A-i é gnun-a regolassion ch\'as peula fesse.',
	'stabilization-sel-short'     => 'Precedensa',
	'stabilization-sel-short-0'   => 'Qualità',
	'stabilization-sel-short-1'   => 'Gnun-a',
	'stabilization-def-short'     => 'Për sòlit',
	'stabilization-def-short-0'   => 'version corenta',
	'stabilization-def-short-1'   => 'version stàbila',
);

