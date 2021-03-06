#!/usr/bin/python
# coding=utf-8
'''
Copyright (C) 2010 by Diederik van Liere (dvanliere@gmail.com)
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License version 2
as published by the Free Software Foundation.
This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
See the GNU General Public License for more details, at
http,//www.fsf.org/licenses/gpl.html
'''

__author__ = '''\n'''.join(['Diederik van Liere (dvanliere@gmail.com)', ])
__author__email = 'dvanliere at gmail dot com'
__date__ = '2010-10-21'
__version__ = '0.1'

'''
This file provides mapper between language name and locale language name and 
Wikipedia acronym. 
Gothic and Birmese are not yet supported, see rows 450 and 554. 
'''

from utils import ordered_dict as odict
MAPPING = odict.OrderedDict([
(u'English','en'),
(u'German','de'),
(u'French','fr'),
(u'Italian','it'),
(u'Polish','pl'),
(u'Japanese','ja'),
(u'Spanish','es'),
(u'Dutch','nl'),
(u'Portuguese','pt'),
(u'Russian','ru'),
(u'Swedish','sv'),
(u'Chinese','zh'),
(u'Catalan','ca'),
(u'Norwegian','no'),
(u'Bokmål','no'),
(u'Finnish','fi'),
(u'Ukrainian','uk'),
(u'Hungarian','hu'),
(u'Czech','cs'),
(u'Romanian','ro'),
(u'Turkish','tr'),
(u'Korean','ko'),
(u'Vietnamese','vi'),
(u'Danish','da'),
(u'Arabic','ar'),
(u'Esperanto','eo'),
(u'Serbian','sr'),
(u'Indonesian','id'),
(u'Lithuanian','lt'),
(u'Volapük','vo'),
(u'Slovak','sk'),
(u'Hebrew','he'),
(u'Bulgarian','bg'),
(u'Persian','fa'),
(u'Slovenian','sl'),
(u'Waray-Waray','war'),
(u'Croatian','hr'),
(u'Estonian','et'),
(u'Malay','ms'),
(u'Newar','new'),
(u'Nepal Bhasa','new'),
(u'Simple English','simple'),
(u'Galician','gl'),
(u'Thai','th'),
(u'Aromanian','roa-rup'),
(u'Nynorsk','nn'),
(u'Basque','eu'),
(u'Hindi','hi'),
(u'Greek','el'),
(u'Haitian','ht'),
(u'Latin','la'),
(u'Telugu','te'),
(u'Georgian','ka'),
(u'Cebuano','ceb'),
(u'Macedonian','mk'),
(u'Azeri','az'),
(u'Tagalog','tl'),
(u'Breton','br'),
(u'Serbo-Croatian','sh'),
(u'Marathi','mr'),
(u'Luxembourgish','lb'),
(u'Javanese','jv'),
(u'Latvian','lv'),
(u'Bosnian','bs'),
(u'Icelandic','is'),
(u'Welsh','cy'),
(u'Belarusian','be-x-old'),
(u'Taraškievica','be-x-old'),
(u'Piedmontese','pms'),
(u'Albanian','sq'),
(u'Tamil','ta'),
(u'Bishnupriya Manipuri','bpy'),
(u'Belarusian','be'),
(u'Aragonese','an'),
(u'Occitan','oc'),
(u'Bengali','bn'),
(u'Swahili','sw'),
(u'Ido','io'),
(u'Ripuarian','ksh'),
(u'Lombard','lmo'),
(u'West Frisian','fy'),
(u'Gujarati','gu'),
(u'Low Saxon','nds'),
(u'Afrikaans','af'),
(u'Sicilian','scn'),
(u'Quechua','qu'),
(u'Kurdish','ku'),
(u'Urdu','ur'),
(u'Sundanese','su'),
(u'Malayalam','ml'),
(u'Cantonese','zh-yue'),
(u'Asturian','ast'),
(u'Neapolitan','nap'),
(u'Samogitian','bat-smg'),
(u'Walloon','wa'),
(u'Chuvash','cv'),
(u'Irish','ga'),
(u'Armenian','hy'),
(u'Yoruba','yo'),
(u'Kannada','kn'),
(u'Tajik','tg'),
(u'Tarantino','roa-tara'),
(u'Venetian','vec'),
(u'Western Panjabi','pnb'),
(u'Nepali','ne'),
(u'Scottish Gaelic','gd'),
(u'Yiddish','yi'),
(u'Min Nan','zh-min-nan'),
(u'Uzbek','uz'),
(u'Tatar','tt'),
(u'Kapampangan','pam'),
(u'Ossetian','os'),
(u'Sakha','sah'),
(u'Alemannic','als'),
(u'Maori','mi'),
(u'Egyptian Arabic','arz'),
(u'Kazakh','kk'),
(u'Nahuatl','nah'),
(u'Limburgian','li'),
(u'Upper Sorbian','hsb'),
(u'Gilaki','glk'),
(u'Corsican','co'),
(u'Gan','gan'),
(u'Amharic','am'),
(u'Mongolian','mn'),
(u'Interlingua','ia'),
(u'Central Bicolano','bcl'),
(u'Võro','fiu-vro'),
(u'Dutch Low Saxon','nds-nl'),
(u'Faroese','fo'),
(u'Turkmen','tk'),
(u'Scots','sco'),
(u'West Flemish','vls'),
(u'Sinhalese','si'),
(u'Sanskrit','sa'),
(u'Bavarian','bar'),
(u'Burmese','my'),
(u'Manx','gv'),
(u'Divehi','dv'),
(u'Norman','nrm'),
(u'Pangasinan','pag'),
(u'Romansh','rm'),
(u'Banyumasan','map-bms'),
(u'Zazaki','diq'),
(u'Sorani','ckb'),
(u'Northern Sami','se'),
(u'Mazandarani','mzn'),
(u'Wu','wuu'),
(u'Uyghur','ug'),
(u'Friulian','fur'),
(u'Ligurian','lij'),
(u'Maltese','mt'),
(u'Bihari','bh'),
(u'Novial','nov'),
(u'Malagasy','mg'),
(u'Kashubian','csb'),
(u'Ilokano','ilo'),
(u'Sardinian','sc'),
(u'Classical Chinese','zh-classical'),
(u'Khmer','km'),
(u'Ladino','lad'),
(u'Pali','pi'),
(u'Anglo-Saxon','ang'),
(u'Zamboanga Chavacano','cbk-zam'),
(u'Tibetan','bo'),
(u'Fiji Hindi','hif'),
(u'Franco-Provençal','frp'),
(u'Arpitan','frp'),
(u'Hakka','hak'),
(u'Cornish','kw'),
(u'Punjabi','pa'),
(u'Pashto','ps'),
(u'Kalmyk','xal'),
(u'Silesian','szl'),
(u'Pennsylvania German','pdc'),
(u'Hawaiian','haw'),
(u'Saterland Frisian','stq'),
(u'Interlingue','ie'),
(u'Navajo','nv'),
(u'Fijian','fj'),
(u'Crimean Tatar','crh'),
(u'Komi','kv'),
(u'Tongan','to'),
(u'Acehnese','ace'),
(u'Somali','so'),
(u'Erzya','myv'),
(u'Guarani','gn'),
(u'Karachay-Balkar','krc'),
(u'Extremaduran','ext'),
(u'Lingala','ln'),
(u'Kirghiz','ky'),
(u'Meadow Mari','mhr'),
(u'Assyrian Neo-Aramaic','arc'),
(u'Emilian-Romagnol','eml'),
(u'Lojban','jbo'),
(u'Picard','pcd'),
(u'Aymara','ay'),
(u'Wolof','wo'),
(u'Tumbuka','tum'),
(u'Kabyle','kab'),
(u'Bashkir','ba'),
(u'North Frisian','frr'),
(u'Tahitian','ty'),
(u'Tok Pisin','tpi'),
(u'Papiamentu','pap'),
(u'Zealandic','zea'),
(u'Sranan','srn'),
(u'Greenlandic','kl'),
(u'Udmurt','udm'),
(u'Chechen','ce'),
(u'Igbo','ig'),
(u'Komi-Permyak','koi'),
(u'Oriya','or'),
(u'Lower Sorbian','dsb'),
(u'Kongo','kg'),
(u'Lao','lo'),
(u'Abkhazian','ab'),
(u'Moksha','mdf'),
(u'Romani','rmy'),
(u'Hill Mari','mrj'),
(u'Banjar','bjn'),
(u'Old Church Slavonic','cu'),
(u'Mirandese','mwl'),
(u'Karakalpak','kaa'),
(u'Samoan','sm'),
(u'Moldovan','mo'),
(u'Tetum','tet'),
(u'Avar','av'),
(u'Kashmiri','ks'),
(u'Gothic','got'),
(u'Sindhi','sd'),
(u'Bambara','bm'),
(u'Nauruan','na'),
(u'Norfolk','pih'),
(u'Pontic','pnt'),
(u'Inuktitut','iu'),
(u'Inupiak','ik'),
(u'Bislama','bi'),
(u'Cherokee','chr'),
(u'Assamese','as'),
(u'Min Dong','cdo'),
(u'Ewe','ee'),
(u'Swati','ss'),
(u'Oromo','om'),
(u'Zhuang','za'),
(u'Zulu','zu'),
(u'Tigrinya','ti'),
(u'Venda','ve'),
(u'Tsonga','ts'),
(u'Hausa','ha'),
(u'Dzongkha','dz'),
(u'Sango','sg'),
(u'Chamorro','ch'),
(u'Cree','cr'),
(u'Xhosa','xh'),
(u'Akan','ak'),
(u'Sesotho','st'),
(u'Kinyarwanda','rw'),
(u'Tswana','tn'),
(u'Kikuyu','ki'),
(u'Buryat','bxr'),
(u'Buginese','bug'),
(u'Chichewa','ny'),
(u'Lak','lbe'),
(u'Twi','tw'),
(u'Shona','sn'),
(u'Kirundi','rn'),
(u'Fula','ff'),
(u'Cheyenne','chy'),
(u'Luganda','lg'),
(u'Ndonga','ng'),
(u'Sichuan Yi','ii'),
(u'Choctaw','cho'),
(u'Marshallese','mh'),
(u'Afar','aa'),
(u'Kuanyama','kj'),
(u'Hiri Motu','ho'),
(u'Muscogee','mus'),
(u'Kanuri','kr'),
(u'Herero','hz'),
(u'English','en'),
(u'Deutsch','de'),
(u'Français','fr'),
(u'Italiano','it'),
(u'Polski','pl'),
(u'日本語','ja'),
(u'Español','es'),
(u'Nederlands','nl'),
(u'Português','pt'),
(u'Русский','ru'),
(u'Svenska','sv'),
(u'中文','zh'),
(u'Català','ca'),
(u'Norsk','no'),
(u'Bokmål','no'),
(u'Suomi','fi'),
(u'Українська','uk'),
(u'Magyar','hu'),
(u'Čeština','cs'),
(u'Română','ro'),
(u'Türkçe','tr'),
(u'한국어','ko'),
(u'Tiếng Việt','vi'),
(u'Dansk','da'),
(u'العربية','ar'),
(u'Esperanto','eo'),
(u'Српски','sr'),
(u'Srpski','sr'),
(u'Bahasa Indonesia','id'),
(u'Lietuvių','lt'),
(u'Volapük','vo'),
(u'Slovenčina','sk'),
(u'עברית','he'),
(u'Български','bg'),
(u'فارسی','fa'),
(u'Slovenščina','sl'),
(u'Winaray','war'),
(u'Hrvatski','hr'),
(u'Eesti','et'),
(u'Bahasa Melayu','ms'),
(u'नेपाल भाषा','new'),
(u'Simple English','simple'),
(u'Galego','gl'),
(u'ไทย','th'),
(u'Armãneashce','roa-rup'),
(u'Nynorsk','nn'),
(u'Euskara','eu'),
(u'हिन्दी','hi'),
(u'Ελληνικά','el'),
(u'Krèyol ayisyen','ht'),
(u'Latina','la'),
(u'తెలుగు','te'),
(u'ქართული','ka'),
(u'Sinugboanong Binisaya','ceb'),
(u'Македонски','mk'),
(u'Azərbaycan','az'),
(u'Tagalog','tl'),
(u'Brezhoneg','br'),
(u'Srpskohrvatski','sh'),
(u'Српскохрватски','sh'),
(u'मराठी','mr'),
(u'Lëtzebuergesch','lb'),
(u'Basa Jawa','jv'),
(u'Latviešu','lv'),
(u'Bosanski','bs'),
(u'Íslenska','is'),
(u'Cymraeg','cy'),
(u'Беларуская','be-x-old'),
(u'тарашкевіца','be-x-old'),
(u'Piemontèis','pms'),
(u'Shqip','sq'),
(u'தமிழ்','ta'),
(u'ইমার ঠার','bpy'),
(u'বিষ্ণুপ্রিয়া মণিপুরী','bpy'),
(u'Беларуская','be'),
(u'Aragonés','an'),
(u'Occitan','oc'),
(u'বাংলা','bn'),
(u'Kiswahili','sw'),
(u'Ido','io'),
(u'Ripoarisch','ksh'),
(u'Lumbaart','lmo'),
(u'Frysk','fy'),
(u'ગુજરાતી','gu'),
(u'Plattdüütsch','nds'),
(u'Afrikaans','af'),
(u'Sicilianu','scn'),
(u'Runa Simi','qu'),
(u'Kurdî','ku'),
(u'كوردی','ku'),
(u'اردو','ur'),
(u'Basa Sunda','su'),
(u'മലയാളം','ml'),
(u'粵語','zh-yue'),
(u'Asturianu','ast'),
(u'Nnapulitano','nap'),
(u'Žemaitėška','bat-smg'),
(u'Walon','wa'),
(u'Чăваш','cv'),
(u'Gaeilge','ga'),
(u'Հայերեն','hy'),
(u'Yorùbá','yo'),
(u'ಕನ್ನಡ','kn'),
(u'Тоҷикӣ','tg'),
(u'Tarandíne','roa-tara'),
(u'Vèneto','vec'),
(u'شاہ مکھی پنجابی','pnb'),
(u'Shāhmukhī Pañjābī','pnb'),
(u'नेपाली','ne'),
(u'Gàidhlig','gd'),
(u'ייִדיש','yi'),
(u'Bân-lâm-gú','zh-min-nan'),
(u'O‘zbek','uz'),
(u'Tatarça','tt'),
(u'Татарча','tt'),
(u'Kapampangan','pam'),
(u'Иронау','os'),
(u'Саха тыла','sah'),
(u'Saxa Tyla','sah'),
(u'Alemannisch','als'),
(u'Māori','mi'),
(u'مصرى','arz'),
(u'Maṣrī','arz'),
(u'Қазақша','kk'),
(u'Nāhuatl','nah'),
(u'Limburgs','li'),
(u'Hornjoserbsce','hsb'),
(u'گیلکی','glk'),
(u'Corsu','co'),
(u'贛語','gan'),
(u'አማርኛ','am'),
(u'Монгол','mn'),
(u'Interlingua','ia'),
(u'Bikol','bcl'),
(u'Võro','fiu-vro'),
(u'Nedersaksisch','nds-nl'),
(u'Føroyskt','fo'),
(u'تركمن ','tk'),
(u'Туркмен','tk'),
(u'Scots','sco'),
(u'West-Vlams','vls'),
(u'සිංහල','si'),
(u'संस्कृतम्','sa'),
(u'Boarisch','bar'),
(u'မ္ရန္‌မာစာ','my'), #Needs fix
(u'Gaelg','gv'),
(u'ދިވެހިބަސް','dv'),
(u'Nouormand','nrm'),
(u'Normaund','nrm'),
(u'Pangasinan','pag'),
(u'Rumantsch','rm'),
(u'Basa Banyumasan','map-bms'),
(u'Zazaki','diq'),
(u'Soranî','ckb'),
(u'کوردی','ckb'),
(u'Sámegiella','se'),
(u'مَزِروني','mzn'),
(u'吴语','wuu'),
(u'Oyghurque','ug'),
(u'Furlan','fur'),
(u'Líguru','lij'),
(u'Malti','mt'),
(u'भोजपुरी','bh'),
(u'Novial','nov'),
(u'Malagasy','mg'),
(u'Kaszëbsczi','csb'),
(u'Ilokano','ilo'),
(u'Sardu','sc'),
(u'古文','zh-classical'),
(u'文言文','zh-classical'),
(u'ភាសាខ្មែរ','km'),
(u'Dzhudezmo','lad'),
(u'पाऴि','pi'),
(u'Englisc','ang'),
(u'Chavacano de Zamboanga','cbk-zam'),
(u'བོད་སྐད','bo'),
(u'Fiji Hindi','hif'),
(u'Arpitan','frp'),
(u'Hak-kâ-fa','hak'),
(u'客家話','hak'),
(u'Kernewek','kw'),
(u'Karnuack','kw'),
(u'ਪੰਜਾਬੀ','pa'),
(u'پښتو','ps'),
(u'Хальмг','xal'),
(u'Ślůnski','szl'),
(u'Deitsch','pdc'),
(u'Hawai`i','haw'),
(u'Seeltersk','stq'),
(u'Interlingue','ie'),
(u'Diné bizaad','nv'),
(u'Na Vosa Vakaviti','fj'),
(u'Qırımtatarca','crh'),
(u'Коми','kv'),
(u'faka Tonga','to'),
(u'Bahsa Acèh','ace'),
(u'Soomaaliga','so'),
(u'Эрзянь','myv'),
(u'Erzjanj Kelj','myv'),
(u"Avañe'ẽ",'gn'),
(u'Къарачай-Малкъар','krc'),
(u'Qarachay-Malqar','krc'),
(u'Estremeñu','ext'),
(u'Lingala','ln'),
(u'Кыргызча','ky'),
(u'Олык Марий','mhr'),
(u'Olyk Marij','mhr'),
(u'ܐܪܡܝܐ','arc'),
(u'Emiliàn e rumagnòl','eml'),
(u'Lojban','jbo'),
(u'Picard','pcd'),
(u'Aymar','ay'),
(u'Wolof','wo'),
(u'chiTumbuka','tum'),
(u'Taqbaylit','kab'),
(u'Башҡорт','ba'),
(u'Frasch','frr'),
(u'Reo Mā`ohi','ty'),
(u'Tok Pisin','tpi'),
(u'Papiamentu','pap'),
(u'Zeêuws','zea'),
(u'Sranantongo','srn'),
(u'Kalaallisut','kl'),
(u'Удмурт кыл','udm'),
(u'Нохчийн','ce'),
(u'Igbo','ig'),
(u'Перем Коми','koi'),
(u'Perem Komi','koi'),
(u'ଓଡ଼ିଆ','or'),
(u'Dolnoserbski','dsb'),
(u'KiKongo','kg'),
(u'ລາວ','lo'),
(u'Аҧсуа','ab'),
(u'Мокшень','mdf'),
(u'Mokshanj Kälj','mdf'),
(u'romani - रोमानी','rmy'),
(u'Кырык Мары','mrj'),
(u'Kyryk Mary','mrj'),
(u'Bahasa Banjar','bjn'),
(u'Словѣньскъ','cu'),
(u'Páigina Percipal','mwl'),
(u'Qaraqalpaqsha','kaa'),
(u'Gagana Samoa','sm'),
(u'Молдовеняскэ','mo'),
(u'Tetun','tet'),
(u'Авар','av'),
(u'कश्मीरी','ks'),
(u'كشميري','ks'),
(u'𐌲𐌿𐍄𐌹𐍃𐌺','got'),   #Needs fix
(u'سنڌي، سندھی ، सिन्ध','sd'),
(u'Bamanankan','bm'),
(u'dorerin Naoero','na'),
(u'Norfuk','pih'),
(u'Ποντιακά','pnt'),
(u'ᐃᓄᒃᑎᑐᑦ','iu'),
(u'Iñupiak','ik'),
(u'Bislama','bi'),
(u'ᏣᎳᎩ','chr'),
(u'অসমীয়া','as'),
(u'Mìng-dĕ̤ng-ngṳ̄','cdo'),
(u'Eʋegbe','ee'),
(u'SiSwati','ss'),
(u'Oromoo','om'),
(u'Cuengh','za'),
(u'isiZulu','zu'),
(u'ትግርኛ','ti'),
(u'Tshivenda','ve'),
(u'Xitsonga','ts'),
(u'هَوُسَ','ha'),
(u'ཇོང་ཁ','dz'),
(u'Sängö','sg'),
(u'Chamoru','ch'),
(u'Nehiyaw','cr'),
(u'isiXhosa','xh'),
(u'Akana','ak'),
(u'Sesotho','st'),
(u'Ikinyarwanda','rw'),
(u'Setswana','tn'),
(u'Gĩkũyũ','ki'),
(u'Буряад','bxr'),
(u'Basa Ugi','bug'),
(u'Chi-Chewa','ny'),
(u'Лакку','lbe'),
(u'Twi','tw'),
(u'chiShona','sn'),
(u'Kirundi','rn'),
(u'Fulfulde','ff'),
(u'Tsetsêhestâhese','chy'),
(u'Luganda','lg'),
(u'Oshiwambo','ng'),
(u'ꆇꉙ','ii'),
(u'Choctaw','cho'),
(u'Ebon','mh'),
(u'Afar','aa'),
(u'Kuanyama','kj'),
(u'Hiri Motu','ho'),
(u'Muskogee','mus'),
(u'Kanuri','kr'),
(u'Otsiherero','hz'),
])