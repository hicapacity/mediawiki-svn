/*
Copyright © 2003,
Center for Intelligent Information Retrieval,
University of Massachusetts, Amherst.
All rights reserved.

Redistribution and use in source and binary forms, with or without modification,
are permitted provided that the following conditions are met:

1. Redistributions of source code must retain the above copyright notice, this
list of conditions and the following disclaimer.

2. Redistributions in binary form must reproduce the above copyright notice,
this list of conditions and the following disclaimer in the documentation
and/or other materials provided with the distribution.

3. The names "Center for Intelligent Information Retrieval" and
"University of Massachusetts" must not be used to endorse or promote products
derived from this software without prior written permission. To obtain
permission, contact info@ciir.cs.umass.edu.

THIS SOFTWARE IS PROVIDED BY UNIVERSITY OF MASSACHUSETTS AND OTHER CONTRIBUTORS
"AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO,
THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE
ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDERS OR CONTRIBUTORS BE
LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR
CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE
GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION)
HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT
LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY
OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF
SUCH DAMAGE.
*/
/* This is a java version of Bob Krovetz' KStem.
 *
 * Java version by Sergio Guzman-Lara.
 * CIIR-UMass Amherst http://ciir.cs.umass.edu
 */
package org.apache.lucene.analysis;

/** A list of words used by Kstem
 */
public class KStemData3 {
    private KStemData3() {
    }
   static String[] data = {
"distasteful","distemper","distempered","distend","distension",
"distil","distill","distillation","distiller","distillery",
"distinct","distinction","distinctive","distinguish","distinguishable",
"distinguished","distort","distortion","distract","distracted",
"distraction","distrain","distraint","distrait","distraught",
"distress","distressing","distribute","distribution","distributive",
"distributor","district","distrust","distrustful","disturb",
"disturbance","disturbed","disunion","disunite","disunity",
"disuse","disused","disyllabic","disyllable","ditch",
"dither","dithers","ditto","ditty","diuretic",
"diurnal","divagate","divan","dive","diver",
"diverge","divergence","divers","diverse","diversify",
"diversion","diversionary","diversity","divert","divertimento",
"divertissement","divest","divide","dividend","dividers",
"divination","divine","diviner","divingboard","divinity",
"divisible","division","divisive","divisor","divorce",
"divot","divulge","divvy","dixie","dixieland",
"dizzy","djinn","dna","do","dobbin",
"doc","docile","dock","docker","docket",
"dockyard","doctor","doctoral","doctorate","doctrinaire",
"doctrinal","doctrine","document","documentary","documentation",
"dodder","doddering","doddle","dodge","dodgems",
"dodger","dodgy","dodo","doe","doer",
"doeskin","doff","dog","dogcart","dogcatcher",
"dogfight","dogfish","dogged","doggerel","doggie",
"doggo","doggone","doggy","doghouse","dogie",
"dogleg","dogma","dogmatic","dogmatics","dogmatism",
"dogs","dogsbody","dogtooth","dogtrot","dogwood",
"doh","doily","doings","doldrums","dole",
"doleful","doll","dollar","dollop","dolly",
"dolmen","dolor","dolorous","dolour","dolphin",
"dolt","domain","dome","domed","domestic",
"domesticate","domesticity","domicile","domiciliary","dominance",
"dominant","dominate","domination","domineer","dominican",
"dominion","domino","dominoes","don","donate",
"donation","donjon","donkey","donkeywork","donnish",
"donor","doodle","doodlebug","doom","doomsday",
"door","doorbell","doorframe","doorkeeper","doorknob",
"doorknocker","doorman","doormat","doornail","doorplate",
"doorscraper","doorstep","doorstopper","doorway","dope",
"dopey","dopy","doric","dormant","dormer",
"dormitory","dormouse","dorsal","dory","dosage",
"dose","doss","dosser","dosshouse","dossier",
"dost","dot","dotage","dote","doth",
"doting","dottle","dotty","double","doubles",
"doublet","doublethink","doubloon","doubly","doubt",
"doubtful","doubtless","douche","dough","doughnut",
"doughty","doughy","dour","douse","dove",
"dovecote","dovetail","dowager","dowdy","dowel",
"dower","down","downbeat","downcast","downdraft",
"downdraught","downer","downfall","downgrade","downhearted",
"downhill","downpour","downright","downstage","downstairs",
"downstream","downtown","downtrodden","downward","downwards",
"downwind","downy","dowry","dowse","doxology",
"doyen","doyley","doze","dozen","dozy",
"dpt","drab","drabs","drachm","drachma",
"draconian","draft","draftee","draftsman","drafty",
"drag","draggled","draggy","dragnet","dragoman",
"dragon","dragonfly","dragoon","drain","drainage",
"drainpipe","drake","dram","drama","dramatic",
"dramatics","dramatise","dramatist","dramatize","drank",
"drape","draper","drapery","drastic","drat",
"draught","draughtboard","draughts","draughtsman","draughty",
"draw","drawback","drawbridge","drawer","drawers",
"drawing","drawl","drawn","drawstring","dray",
"dread","dreadful","dreadfully","dreadnaught","dreadnought",
"dream","dreamboat","dreamer","dreamland","dreamless",
"dreamlike","dreamy","drear","dreary","dredge",
"dredger","dregs","drench","dress","dressage",
"dresser","dressing","dressmaker","dressy","drew",
"dribble","driblet","dribs","drier","drift",
"driftage","drifter","driftnet","driftwood","drill",
"drily","drink","drinkable","drinker","drip",
"dripping","drive","drivel","driver","driveway",
"driving","drizzle","drogue","droll","drollery",
"dromedary","drone","drool","droop","drop",
"dropkick","droplet","dropout","dropper","droppings",
"drops","dropsy","dross","drought","drove",
"drover","drown","drowse","drowsy","drub",
"drudge","drudgery","drug","drugget","druggist",
"drugstore","druid","drum","drumbeat","drumfire",
"drumhead","drummer","drumstick","drunk","drunkard",
"drunken","drupe","dry","dryad","dryer",
"dual","dub","dubbin","dubiety","dubious",
"ducal","ducat","duchess","duchy","duck",
"duckboards","duckling","ducks","duckweed","ducky",
"duct","ductile","dud","dude","dudgeon",
"duds","due","duel","duenna","dues",
"duet","duff","duffel","duffer","duffle",
"dug","dugout","duke","dukedom","dukes",
"dulcet","dulcimer","dull","dullard","duly",
"dumb","dumbbell","dumbfound","dumbwaiter","dumfound",
"dummy","dump","dumper","dumpling","dumps",
"dumpy","dun","dunce","dunderhead","dung",
"dungaree","dungarees","dungeon","dunghill","dunk",
"duo","duodecimal","duodenum","duologue","dupe",
"duplex","duplicate","duplicator","duplicity","durable",
"duration","durbar","duress","durex","during",
"durst","dusk","dusky","dust","dustbin",
"dustbowl","dustcart","dustcoat","duster","dustman",
"dustpan","dustsheet","dustup","dusty","dutch",
"dutiable","dutiful","duty","duvet","dwarf",
"dwell","dwelling","dwindle","dyarchy","dye",
"dyestuff","dyeworks","dyke","dynamic","dynamics",
"dynamism","dynamite","dynamo","dynasty","dysentery",
"dyslexia","dyspepsia","dyspeptic","each","eager",
"eagle","eaglet","ear","earache","eardrum",
"eared","earful","earl","earliest","earlobe",
"early","earmark","earmuff","earn","earnest",
"earnings","earphone","earpiece","earplug","earring",
"earshot","earth","earthbound","earthen","earthenware",
"earthling","earthly","earthnut","earthquake","earthshaking",
"earthwork","earthworm","earthy","earwax","earwig",
"ease","easel","easily","east","eastbound",
"easter","easterly","eastern","easterner","easternmost",
"easy","easygoing","eat","eatable","eatables",
"eater","eats","eaves","eavesdrop","ebb",
"ebony","ebullience","ebullient","eccentric","eccentricity",
"ecclesiastic","ecclesiastical","ecg","echelon","echo",
"eclectic","eclipse","ecliptic","eclogue","ecological",
"ecologically","ecology","economic","economical","economically",
"economics","economise","economist","economize","economy",
"ecosystem","ecstasy","ecstatic","ect","ectoplasm",
"ecumenical","ecumenicalism","eczema","edam","eddy",
"edelweiss","eden","edge","edgeways","edging",
"edgy","edible","edibles","edict","edification",
"edifice","edify","edit","edition","editor",
"editorial","editorialise","editorialize","educate","educated",
"education","educational","educationist","educator","educe",
"eec","eeg","eel","eerie","efface",
"effect","effective","effectively","effectiveness","effectives",
"effects","effectual","effectually","effectuate","effeminacy",
"effeminate","effendi","effervesce","effete","efficacious",
"efficacy","efficiency","efficient","effigy","efflorescence",
"effluent","efflux","effort","effortless","effrontery",
"effulgence","effulgent","effusion","effusive","eft",
"egalitarian","egg","eggcup","egghead","eggnog",
"eggplant","eggshell","egis","eglantine","ego",
"egocentric","egoism","egoist","egotism","egotist",
"egregious","egress","egret","eiderdown","eight",
"eighteen","eightsome","eighty","eisteddfod","either",
"ejaculate","ejaculation","eject","ejector","eke",
"ekg","elaborate","elaboration","eland","elapse",
"elastic","elasticity","elastoplast","elate","elated",
"elation","elbow","elbowroom","elder","elderberry",
"elderflower","elderly","eldest","elect","election",
"electioneer","electioneering","elective","elector","electoral",
"electorate","electric","electrical","electrician","electricity",
"electrify","electrocardiogram","electrocardiograph","electrocute","electrode",
"electroencephalogram","electroencephalograph","electrolysis","electrolyte","electron",
"electronic","electronics","electroplate","eleemosynary","elegant",
"elegiac","elegy","element","elemental","elementary",
"elements","elephant","elephantiasis","elephantine","elevate",
"elevated","elevation","elevator","eleven","elevenses",
"elf","elfin","elfish","elicit","elide",
"eligible","eliminate","elite","elitism","elixir",
"elizabethan","elk","elkhound","ellipse","ellipsis",
"elliptic","elm","elocution","elocutionary","elocutionist",
"elongate","elongation","elope","eloquence","eloquent",
"else","elsewhere","elucidate","elucidatory","elude",
"elusive","elver","elves","elvish","elysian",
"elysium","emaciate","emanate","emancipate","emancipation",
"emasculate","embalm","embankment","embargo","embark",
"embarkation","embarrass","embarrassment","embassy","embattled",
"embed","embellish","ember","embezzle","embitter",
"emblazon","emblem","emblematic","embodiment","embody",
"embolden","embolism","embonpoint","embosomed","emboss",
"embowered","embrace","embrasure","embrocation","embroider",
"embroidery","embroil","embryo","embryonic","emend",
"emendation","emerald","emerge","emergence","emergency",
"emergent","emeritus","emery","emetic","emigrant",
"emigrate","eminence","eminent","eminently","emir",
"emirate","emissary","emission","emit","emmentaler",
"emmenthaler","emollient","emolument","emote","emotion",
"emotional","emotionalism","emotionally","emotive","empanel",
"empathy","emperor","emphasis","emphasise","emphasize",
"emphatic","emphatically","emphysema","empire","empirical",
"empiricism","emplacement","emplane","employ","employable",
"employee","employer","employment","emporium","empower",
"empress","emptily","empty","empurpled","empyreal",
"empyrean","emu","emulate","emulation","emulsify",
"emulsion","enable","enabling","enact","enactment",
"enamel","enamelware","enamored","enamoured","encamp",
"encampment","encapsulate","encase","encaustic","encephalitis",
"enchain","enchant","enchanter","enchanting","enchantment",
"encipher","encircle","enclave","enclose","enclosure",
"encode","encomium","encompass","encore","encounter",
"encourage","encouragement","encroach","encroachment","encrust",
"encumber","encumbrance","encyclical","encyclopaedia","encyclopaedic",
"encyclopedia","encyclopedic","end","endanger","endear",
"endearing","endearment","endeavor","endeavour","endemic",
"ending","endive","endless","endocrine","endorse",
"endow","endowment","endpaper","endurance","endure",
"enduring","endways","enema","enemy","energetic",
"energize","energy","enervate","enfeeble","enfilade",
"enfold","enforce","enfranchise","engage","engaged",
"engagement","engaging","engender","engine","engineer",
"engineering","english","englishman","engraft","engrave",
"engraving","engross","engrossing","engulf","enhance",
"enigma","enigmatic","enjoin","enjoy","enjoyable",
"enjoyment","enkindle","enlarge","enlargement","enlighten",
"enlightened","enlightenment","enlist","enliven","enmesh",
"enmity","ennoble","ennui","enormity","enormous",
"enormously","enough","enplane","enquire","enquiring",
"enquiry","enrage","enrapture","enrich","enrol",
"enroll","enrollment","enrolment","ensanguined","ensconce",
"ensemble","enshrine","enshroud","ensign","enslave",
"ensnare","ensue","ensure","entail","entangle",
"entanglement","entente","enter","enteritis","enterprise",
"enterprising","entertain","entertainer","entertaining","entertainment",
"enthral","enthrall","enthrone","enthroned","enthuse",
"enthusiasm","enthusiast","entice","enticement","entire",
"entirety","entitle","entity","entomb","entomology",
"entourage","entrails","entrain","entrance","entrant",
"entrap","entreat","entreaty","entrench","entrenched",
"entrenchment","entrepreneur","entresol","entropy","entrust",
"entry","entwine","enumerate","enunciate","enunciation",
"envelop","envenom","enviable","envious","environed",
"environment","environmental","environmentalist","environs","envisage",
"envoi","envoy","envy","enzyme","eon",
"epaulet","epaulette","ephemeral","epic","epicenter",
"epicentre","epicure","epicurean","epidemic","epidermis",
"epidiascope","epiglottis","epigram","epigrammatic","epilepsy",
"epileptic","epilogue","epiphany","episcopacy","episcopal",
"episcopalian","episode","episodic","epistle","epistolary",
"epitaph","epithet","epitome","epitomise","epitomize",
"epoch","eponymous","equability","equable","equal",
"equalise","equalitarian","equality","equalize","equally",
"equanimity","equate","equation","equator","equatorial",
"equerry","equestrian","equidistant","equilateral","equilibrium",
"equine","equinoctial","equinox","equip","equipage",
"equipment","equipoise","equitable","equitation","equities",
"equity","equivalence","equivalent","equivocal","equivocate",
"equivocation","era","eradicate","eradicator","erase",
"eraser","erasure","ere","erect","erectile",
"erection","eremite","erg","ergo","ergonomics",
"ermine","erode","erogenous","erosion","erotic",
"erotica","eroticism","err","errand","errant",
"erratic","erratum","erroneous","error","ersatz",
"erse","eructation","erudite","erupt","eruption",
"erysipelas","escalate","escalator","escalope","escapade",
"escape","escapee","escapement","escapism","escapology",
"escarpment","eschatology","eschew","escort","escritoire",
"escutcheon","eskimo","esophagus","esoteric","esp",
"espalier","especial","especially","esperanto","espionage",
"esplanade","espousal","espouse","espresso","espy",
"essay","essence","essential","essentially","establish",
"establishment","estaminet","estate","esteem","esthete",
"esthetic","esthetics","estimable","estimate","estimation",
"estimator","estrange","estrangement","estrogen","estuary",
"etch","etching","eternal","eternity","ether",
"ethereal","ethic","ethical","ethically","ethics",
"ethnic","ethnically","ethnographer","ethnography","ethnologist",
"ethnology","ethos","ethyl","etiolate","etiology",
"etiquette","etymologist","etymology","eucalyptus","eucharist",
"euclidean","euclidian","eugenic","eugenics","eulogise",
"eulogist","eulogistic","eulogize","eulogy","eunuch",
"euphemism","euphemistic","euphonious","euphonium","euphony",
"euphoria","euphuism","eurasian","eureka","eurhythmic",
"eurhythmics","eurocrat","eurodollar","eurythmic","eurythmics",
"euthanasia","evacuate","evacuee","evade","evaluate",
"evanescent","evangelic","evangelical","evangelise","evangelist",
"evangelize","evaporate","evasion","evasive","eve",
"even","evening","evenings","evens","evensong",
"event","eventful","eventide","eventual","eventuality",
"eventually","eventuate","ever","evergreen","everlasting",
"everlastingly","evermore","every","everybody","everyday",
"everything","everywhere","evict","evidence","evident",
"evidently","evil","evildoer","evince","eviscerate",
"evocative","evoke","evolution","evolutionary","evolve",
"ewe","ewer","exacerbate","exact","exacting",
"exaction","exactly","exaggerate","exaggeration","exalt",
"exaltation","exalted","exam","examination","examine",
"example","exasperate","exasperation","excavate","excavation",
"excavator","exceed","exceedingly","excel","excellence",
"excellency","excellent","excelsior","except","excepted",
"excepting","exception","exceptionable","exceptional","excerpt",
"excess","excesses","excessive","exchange","exchequer",
"excise","excision","excitable","excite","excited",
"excitement","exciting","exclaim","exclamation","exclamatory",
"exclude","excluding","exclusion","exclusive","exclusively",
"excogitate","excommunicate","excommunication","excoriate","excrement",
"excrescence","excreta","excrete","excretion","excruciating",
"exculpate","excursion","excursionist","excusable","excuse",
"execrable","execrate","executant","execute","execution",
"executioner","executive","executor","exegesis","exemplary",
"exemplification","exemplify","exempt","exemption","exercise",
"exercises","exert","exertion","exeunt","exhalation",
"exhale","exhaust","exhaustion","exhaustive","exhibit",
"exhibition","exhibitionism","exhibitor","exhilarate","exhilarating",
"exhort","exhortation","exhume","exigency","exigent",
"exiguous","exile","exist","existence","existent",
"existential","existentialism","existing","exit","exodus",
"exogamy","exonerate","exorbitant","exorcise","exorcism",
"exorcist","exorcize","exotic","expand","expanse",
"expansion","expansive","expatiate","expatriate","expect",
"expectancy","expectant","expectation","expectations","expectorate",
"expediency","expedient","expedite","expedition","expeditionary",
"expeditious","expel","expend","expendable","expenditure",
"expense","expenses","expensive","experience","experienced",
"experiment","experimental","experimentation","expert","expertise",
"expiate","expiration","expire","explain","explanation",
"explanatory","expletive","explicable","explicate","explicit",
"explode","exploded","exploit","exploration","exploratory",
"explore","explosion","explosive","expo","exponent",
"exponential","export","exportation","exporter","expose",
"exposition","expostulate","exposure","expound","express",
"expression","expressionism","expressionless","expressive","expressly",
"expressway","expropriate","expulsion","expunge","expurgate",
"exquisite","extant","extemporaneous","extempore","extemporise",
"extemporize","extend","extension","extensive","extent",
"extenuate","extenuation","exterior","exteriorise","exteriorize",
"exterminate","external","externalise","externalize","externally",
"externals","exterritorial","extinct","extinction","extinguish",
"extinguisher","extirpate","extol","extort","extortion",
"extortionate","extortions","extra","extract","extraction",
"extracurricular","extraditable","extradite","extrajudicial","extramarital",
"extramural","extraneous","extraordinarily","extraordinary","extrapolate",
"extraterrestrial","extraterritorial","extravagance","extravagant","extravaganza",
"extravert","extreme","extremely","extremism","extremities",
"extremity","extricate","extrinsic","extrovert","extrude",
"exuberance","exuberant","exude","exult","exultant",
"exultation","eye","eyeball","eyebrow","eyecup",
"eyeful","eyeglass","eyeglasses","eyelash","eyelet",
"eyelid","eyeliner","eyepiece","eyes","eyeshot",
"eyesight","eyesore","eyestrain","eyetooth","eyewash",
"eyewitness","eyot","eyrie","eyry","fabian",
"fable","fabled","fabric","fabricate","fabrication",
"fabulous","fabulously","face","facecloth","faceless",
"facet","facetious","facial","facile","facilitate",
"facilities","facility","facing","facings","facsimile",
"fact","faction","factious","factitious","factor",
"factorial","factorise","factorize","factory","factotum",
"factual","faculty","fad","fade","faeces",
"faerie","faery","fag","fagged","faggot",
"fagot","fahrenheit","faience","fail","failing",
"failure","fain","faint","fair","fairground",
"fairly","fairway","fairy","fairyland","faith",
"faithful","faithfully","faithless","fake","fakir",
"falcon","falconer","falconry","fall","fallacious",
"fallacy","fallen","fallible","fallout","fallow",
"falls","false","falsehood","falsetto","falsies",
"falsify","falsity","falter","fame","famed",
"familial","familiar","familiarise","familiarity","familiarize",
"familiarly","family","famine","famish","famished",
"famous","famously","fan","fanatic","fanaticism",
"fancier","fancies","fanciful","fancy","fancywork",
"fandango","fanfare","fang","fanlight","fanny",
"fantasia","fantastic","fantasy","far","faraway",
"farce","fare","farewell","farfetched","farinaceous",
"farm","farmer","farmhand","farmhouse","farming",
"farmyard","farrago","farrier","farrow","farsighted",
"fart","farther","farthest","farthing","fascia",
"fascinate","fascinating","fascination","fascism","fascist",
"fashion","fashionable","fast","fasten","fastener",
"fastening","fastidious","fastness","fat","fatal",
"fatalism","fatalist","fatality","fatally","fate",
"fated","fateful","fates","fathead","father",
"fatherhood","fatherly","fathom","fathomless","fatigue",
"fatigues","fatless","fatted","fatten","fatty",
"fatuity","fatuous","faucet","fault","faultfinding",
"faultless","faulty","faun","fauna","favor",
"favorable","favored","favorite","favoritism","favour",
"favourable","favoured","favourite","favouritism","favours",
"fawn","fay","faze","fbi","fealty",
"fear","fearful","fearless","fearsome","feasible",
"feast","feat","feather","featherbed","featherbrained",
"featherweight","feathery","feature","featureless","features",
"febrile","february","feces","feckless","fecund",
"fed","federal","federalism","federalist","federate",
"federation","fee","feeble","feebleminded","feed",
"feedback","feedbag","feeder","feel","feeler",
"feeling","feelings","feet","feign","feint",
"feldspar","felicitate","felicitous","felicity","feline",
"fell","fellah","fellatio","fellow","fellowship",
"felon","felony","felspar","felt","felucca",
"fem","female","feminine","femininity","feminism",
"feminist","femur","fen","fence","fencer",
"fencing","fend","fender","fennel","feoff",
"feral","ferment","fermentation","fern","ferocious",
"ferocity","ferret","ferroconcrete","ferrous","ferrule",
"ferry","ferryboat","ferryman","fertile","fertilise",
"fertility","fertilize","fertilizer","ferule","fervent",
"fervid","fervor","fervour","festal","fester",
"festival","festive","festivity","festoon","fetal",
"fetch","fetching","fete","fetid","fetish",
"fetishism","fetishist","fetlock","fetter","fettle",
"fetus","feud","feudal","feudalism","feudatory",
"fever","fevered","feverish","feverishly","few",
"fey","fez","fiasco","fiat","fib",
"fiber","fiberboard","fiberglass","fibre","fibreboard",
"fibreglass","fibrositis","fibrous","fibula","fichu",
"fickle","fiction","fictional","fictionalisation","fictionalization",
"fictitious","fiddle","fiddler","fiddlesticks","fiddling",
"fidelity","fidget","fidgets","fidgety","fie",
"fief","field","fielder","fieldwork","fiend",
"fiendish","fiendishly","fierce","fiery","fiesta",
"fife","fifteen","fifth","fifty","fig",
"fight","fighter","figment","figurative","figure",
"figured","figurehead","figures","figurine","filament",
"filbert","filch","file","filet","filial",
"filibuster","filigree","filings","fill","filler",
"fillet","filling","fillip","filly","film",
"filmable","filmstrip","filmy","filter","filth",
"filthy","fin","finable","final","finale",
"finalise","finalist","finality","finalize","finally",
"finance","finances","financial","financially","financier",
"finch","find","finder","finding","fine",
"fineable","finely","finery","finesse","finger",
"fingerboard","fingering","fingernail","fingerplate","fingerpost",
"fingerprint","fingerstall","fingertip","finicky","finis",
"finish","finished","finite","fink","fiord",
"fir","fire","firearm","fireball","firebomb",
"firebox","firebrand","firebreak","firebrick","firebug",
"fireclay","firecracker","firedamp","firedog","firefly",
"fireguard","firelight","firelighter","fireman","fireplace",
"firepower","fireproof","fireside","firestorm","firetrap",
"firewalking","firewatcher","firewater","firewood","firework",
"fireworks","firkin","firm","firmament","first",
"firstborn","firstfruits","firsthand","firstly","firth",
"firtree","fiscal","fish","fishcake","fisherman",
"fishery","fishing","fishmonger","fishplate","fishwife",
"fishy","fissile","fission","fissionable","fissure",
"fist","fisticuffs","fistula","fit","fitful",
"fitment","fitness","fitted","fitter","fitting",
"five","fiver","fives","fix","fixation",
"fixative","fixed","fixedly","fixity","fixture",
"fizz","fizzle","fizzy","fjord","flabbergast",
"flabby","flaccid","flag","flagellant","flagellate",
"flageolet","flagon","flagpole","flagrancy","flagrant",
"flagship","flagstaff","flagstone","flail","flair",
"flak","flake","flaky","flambeau","flamboyant",
"flame","flamenco","flaming","flamingo","flammable",
"flan","flange","flank","flannel","flannelette",
"flannels","flap","flapjack","flapper","flare",
"flared","flares","flash","flashback","flashbulb",
"flashcube","flasher","flashgun","flashlight","flashy",
"flask","flat","flatcar","flatfish","flatfoot",
"flatiron","flatlet","flatly","flatten","flatter",
"flattery","flattop","flatulence","flaunt","flautist",
"flavor","flavoring","flavour","flavouring","flaw",
"flawless","flax","flaxen","flay","flea",
"fleabag","fleabite","fleapit","fleck","fledged",
"fledgling","flee","fleece","fleecy","fleet",
"fleeting","flesh","fleshings","fleshly","fleshpot",
"fleshy","flew","flex","flexible","flibbertigibbet",
"flick","flicker","flicks","flier","flies",
"flight","flightless","flighty","flimsy","flinch",
"fling","flint","flintlock","flinty","flip",
"flippancy","flippant","flipper","flipping","flirt",
"flirtation","flirtatious","flit","flitch","flivver",
"float","floatation","floating","flock","floe",
"flog","flogging","flood","floodgate","floodlight",
"floor","floorboard","flooring","floorwalker","floosy",
"floozy","flop","floppy","flora","floral",
"floriculture","florid","florin","florist","floss",
"flotation","flotilla","flounce","flounder","flour",
"flourish","flourmill","floury","flout","flow",
"flower","flowerbed","flowered","flowering","flowerless",
"flowerpot","flowery","flowing","flown","flu",
"fluctuate","flue","fluency","fluent","fluff",
"fluffy","fluid","fluidity","fluke","flukey",
"fluky","flume","flummery","flummox","flung",
"flunk","flunkey","flunky","fluorescent","fluoridate",
"fluoride","fluorine","flurry","flush","flushed",
"fluster","flute","fluting","flutist","flutter",
"fluvial","flux","fly","flyaway","flyblown",
"flyby","flycatcher","flyer","flying","flyleaf",
"flyover","flypaper","flypast","flysheet","flyswatter",
"flytrap","flyweight","flywheel","flywhisk","foal",
"foam","fob","focal","focus","fodder",
"foe","foeman","foetal","foetus","fog",
"fogbank","fogbound","fogey","foggy","foghorn",
"fogy","foible","foil","foist","fold",
"foldaway","folder","foliage","folio","folk",
"folklore","folklorist","folks","folksy","folktale",
"folkway","follicle","follow","follower","following",
"folly","foment","fomentation","fond","fondant",
"fondle","fondly","fondu","fondue","font",
"food","foodstuff","fool","foolery","foolhardy",
"foolish","foolproof","foolscap","foot","footage",
"football","footbath","footboard","footbridge","footer",
"footfall","foothill","foothold","footing","footle",
"footlights","footling","footloose","footman","footnote",
"footpad","footpath","footplate","footprint","footrace",
"footsie","footslog","footsore","footstep","footstool",
"footsure","footwear","footwork","fop","foppish",
"for","forage","foray","forbear","forbearance",
"forbearing","forbid","forbidden","forbidding","force",
"forced","forceful","forcemeat","forceps","forces",
"forcible","forcibly","ford","fore","forearm",
"forebode","foreboding","forecast","forecastle","foreclose",
"foreclosure","forecourt","foredoomed","forefather","forefinger",
"forefoot","forefront","forego","foregoing","foreground",
"forehand","forehead","foreign","foreigner","foreknowledge",
"foreland","foreleg","forelock","foreman","foremost",
"forename","forenoon","forensic","foreordain","forepart",
"foreplay","forerunner","foresail","foresee","foreseeable",
"foreshadow","foreshore","foreshorten","foresight","foreskin",
"forest","forestall","forester","forestry","foreswear",
"foretaste","foretell","forethought","forever","forewarn",
"forewent","forewoman","foreword","forfeit","forfeiture",
"forgather","forgave","forge","forger","forgery",
"forget","forgetful","forging","forgivable","forgive",
"forgiveable","forgiveness","forgiving","forgo","fork",
"forked","forkful","forklift","forlorn","form",
"formal","formaldehyde","formalin","formalise","formalism",
"formality","formalize","format","formation","formative",
"formbook","former","formerly","formica","formidable",
"formless","formula","formulaic","formulate","formulation",
"fornicate","fornication","forrader","forsake","forsooth",
"forswear","forsythia","fort","forte","forth",
"forthcoming","forthright","forthwith","fortieth","fortification",
"fortify","fortissimo","fortitude","fortnight","fortnightly",
"fortress","fortuitous","fortunate","fortunately","fortune",
"forty","forum","forward","forwarding","forwardly",
"forwardness","forwent","foss","fosse","fossil",
"fossilise","fossilize","foster","fought","foul",
"found","foundation","foundations","founder","foundling",
"foundry","fount","fountain","fountainhead","four",
"foureyes","fourpenny","fours","foursquare","fourteen",
"fourth","fowl","fox","foxglove","foxhole",
"foxhound","foxhunt","foxtrot","foxy","foyer",
"fracas","fraction","fractional","fractionally","fractious",
"fracture","fragile","fragment","fragmentary","fragmentation",
"fragrance","fragrant","frail","frailty","frame",
"frames","framework","franc","franchise","franciscan",
"frank","frankfurter","frankincense","franklin","frankly",
"frantic","fraternal","fraternise","fraternity","fraternize",
"fratricide","frau","fraud","fraudulence","fraudulent",
"fraught","fraulein","fray","frazzle","freak",
"freakish","freckle","free","freebee","freebie",
"freeboard","freebooter","freeborn","freedman","freedom",
"freehand","freehanded","freehold","freeholder","freelance",
"freeload","freely","freeman","freemason","freemasonry",
"freepost","freesia","freestanding","freestone","freestyle",
"freethinker","freeway","freewheel","freewheeling","freewill",
"freeze","freezer","freezing","freight","freighter",
"freightliner","frenchman","frenetic","frenzied","frenzy",
"frequency","frequent","fresco","fresh","freshen",
"fresher","freshet","freshly","freshwater","fret",
"fretful","fretsaw","fretwork","freudian","friable",
"friar","friary","fricassee","fricative","friction",
"friday","fridge","friend","friendless","friendly",
"friends","friendship","frier","frieze","frig",
"frigate","frigging","fright","frighten","frightened",
"frightful","frightfully","frigid","frigidity","frill",
"frilled","frills","frilly","fringe","frippery",
"frisbee","frisian","frisk","frisky","frisson",
"fritter","frivolity","frivolous","frizz","frizzle",
"frizzy","fro","frock","frog","frogged",
"frogman","frogmarch","frogspawn","frolic","frolicsome",
"from","frond","front","frontage","frontal",
"frontbench","frontier","frontiersman","frontispiece","frost",
"frostbite","frostbitten","frostbound","frosting","frosty",
"froth","frothy","frown","frowst","frowsty",
"frowsy","frowzy","froze","frozen","frs",
"fructification","fructify","frugal","frugality","fruit",
"fruitcake","fruiterer","fruitful","fruition","fruitless",
"fruits","fruity","frump","frustrate","frustration",
"fry","fryer","fuchsia","fuck","fucker",
"fucking","fuddle","fudge","fuehrer","fuel",
"fug","fugitive","fugue","fuhrer","fulcrum",
"fulfil","fulfill","fulfillment","fulfilment","full",
"fullback","fuller","fully","fulmar","fulminate",
"fulmination","fulness","fulsome","fumble","fume",
"fumes","fumigate","fun","function","functional",
"functionalism","functionalist","functionary","fund","fundamental",
"fundamentalism","fundamentally","funds","funeral","funerary",
"funereal","funfair","fungicide","fungoid","fungous",
"fungus","funicular","funk","funky","funnel",
"funnies","funnily","funny","fur","furbelow",
"furbish","furious","furiously","furl","furlong",
"furlough","furnace","furnish","furnishings","furniture",
"furore","furrier","furrow","furry","further",
"furtherance","furthermore","furthermost","furthest","furtive",
"fury","furze","fuse","fused","fuselage",
"fusilier","fusillade","fusion","fuss","fusspot",
"fussy","fustian","fusty","futile","futility",
"future","futureless","futures","futurism","futuristic",
"futurity","fuzz","fuzzy","gab","gabardine",
"gabble","gaberdine","gable","gabled","gad",
"gadabout","gadfly","gadget","gadgetry","gaelic",
"gaff","gaffe","gaffer","gag","gaga",
"gaggle","gaiety","gaily","gain","gainful",
"gainfully","gainsay","gait","gaiter","gal",
"gala","galactic","galantine","galaxy","gale",
"gall","gallant","gallantry","galleon","gallery",
"galley","gallic","gallicism","gallivant","gallon",
"gallop","galloping","gallows","gallstone","galore",
"galosh","galumph","galvanic","galvanise","galvanism",
"galvanize","gambit","gamble","gamboge","gambol",
"game","gamecock","gamekeeper","games","gamesmanship",
"gamey","gamma","gammon","gammy","gamp",
"gamut","gamy","gander","gang","ganger",
"gangling","ganglion","gangplank","gangrene","gangster",
"gangway","gannet","gantry","gaol","gaolbird",
"gaoler","gap","gape","gapes","garage",
"garb","garbage","garble","garden","gardenia",
"gardening","gargantuan","gargle","gargoyle","garish",
"garland","garlic","garment","garner","garnet",
"garnish","garret","garrison","garrote","garrotte",
"garrulity","garrulous","garter","gas","gasbag",
"gaseous","gash","gasholder","gasify","gasket",
"gaslight","gasman","gasolene","gasoline","gasp",
"gassy","gastric","gastritis","gastroenteritis","gastronomy",
"gasworks","gat","gate","gatecrash","gatehouse",
"gatekeeper","gatepost","gateway","gather","gathering",
"gauche","gaucherie","gaucho","gaudy","gauge",
"gaunt","gauntlet","gauze","gave","gavel",
"gavotte","gawk","gawky","gawp","gay",
"gayness","gaze","gazebo","gazelle","gazette",
"gazetteer","gazump","gce","gear","gearbox",
"gecko","gee","geese","geezer","geisha",
"gel","gelatine","gelatinous","geld","gelding",
"gelignite","gem","gemini","gen","gendarme",
"gender","gene","genealogist","genealogy","genera",
"general","generalisation","generalise","generalissimo","generality",
"generalization","generalize","generally","generate","generation",
"generative","generator","generic","generous","genesis",
"genetic","geneticist","genetics","genial","geniality",
"genie","genital","genitals","genitive","genius",
"genocide","genre","gent","genteel","gentian",
"gentile","gentility","gentle","gentlefolk","gentleman",
"gentlemanly","gentlewoman","gently","gentry","gents",
"genuflect","genuine","genus","geocentric","geographer",
"geography","geologist","geology","geometric","geometry",
"geophysics","geopolitics","georgette","geranium","geriatric",
"geriatrician","geriatrics","germ","germane","germanic",
"germicide","germinal","germinate","gerontology","gerrymander",
"gerund","gestalt","gestapo","gestation","gesticulate",
"gesture","get","getaway","getup","geum",
"gewgaw","geyser","gharry","ghastly","ghat",
"ghaut","ghee","gherkin","ghetto","ghi",
"ghost","ghostly","ghoul","ghoulish","ghq",
"ghyll","giant","giantess","gibber","gibberish",
"gibbet","gibbon","gibbous","gibe","giblets",
"giddy","gift","gifted","gig","gigantic",
"giggle","gigolo","gild","gilded","gilding",
"gill","gillie","gilly","gilt","gimcrack",
"gimlet","gimmick","gimmicky","gin","ginger",
"gingerbread","gingerly","gingham","gingivitis","gingko",
"ginkgo","ginseng","gipsy","giraffe","gird",
"girder","girdle","girl","girlfriend","girlhood",
"girlie","girlish","girly","giro","girt",
"girth","gist","give","giveaway","given",
"gizzard","glacial","glacier","glad","gladden",
"glade","gladiator","gladiolus","gladly","glamor",
"glamorise","glamorize","glamorous","glamour","glamourous",
"glance","glancing","gland","glandular","glare",
"glaring","glass","glassblower","glasscutter","glasses",
"glasshouse","glassware","glassworks","glassy","glaucoma",
"glaucous","glaze","glazier","glazing","glc",
"gleam","glean","gleaner","gleanings","glebe",
"glee","gleeful","glen","glengarry","glib",
"glide","glider","gliding","glimmer","glimmerings",
"glimpse","glint","glissade","glissando","glisten",
"glister","glitter","glittering","gloaming","gloat",
"global","globe","globefish","globetrotter","globular",
"globule","glockenspiel","gloom","gloomy","gloria",
"glorification","glorify","glorious","glory","gloss",
"glossary","glossy","glottal","glottis","glove",
"glow","glower","glowing","glucose","glue",
"gluey","glum","glut","gluten","glutinous",
"glutton","gluttonous","gluttony","glycerin","glycerine",
"gnarled","gnash","gnat","gnaw","gnawing",
"gneiss","gnocchi","gnome","gnp","gnu",
"goad","goal","goalkeeper","goalmouth","goalpost",
"goat","goatee","goatherd","goatskin","gob",
"gobbet","gobble","gobbledegook","gobbledygook","gobbler",
"goblet","goblin","god","godchild","goddam",
"goddamn","goddie","godforsaken","godhead","godless",
"godlike","godly","godown","godparent","gods",
"godsend","godspeed","goer","goggle","goggles",
"goings","goiter","goitre","gold","goldbeater",
"golden","goldfield","goldfinch","goldfish","goldmine",
"goldsmith","golf","goliath","golliwog","golly",
"gollywog","gonad","gondola","gondolier","gone",
"goner","gong","gonna","gonorrhea","gonorrhoea",
"goo","good","goodbye","goodish","goodly",
"goodness","goodnight","goods","goodwill","goody",
"gooey","goof","goofy","googly","goon",
"goose","gooseberry","gooseflesh","goosestep","gopher",
"gore","gorge","gorgeous","gorgon","gorgonzola",
"gorilla","gormandise","gormandize","gormless","gorse",
"gory","gosh","gosling","gospel","gossamer",
"gossip","gossipy","got","gothic","gotta",
"gotten","gouache","gouda","gouge","goulash",
"gourd","gourmand","gourmet","gout","gouty",
"govern","governance","governess","governing","government",
"governor","gown","gpo","grab","grace",
"graceful","graceless","graces","gracious","gradation",
"grade","gradient","gradual","graduate","graduation",
"graffiti","graft","grafter","grail","grain",
"gram","grammar","grammarian","grammatical","gramme",
"gramophone","grampus","gran","granary","grand",
"grandad","grandchild","granddad","granddaughter","grandee",
"grandeur","grandfather","grandiloquent","grandiose","grandma",
"grandmother","grandpa","grandparent","grandson","grandstand",
"grange","granite","grannie","granny","grant",
};
}
