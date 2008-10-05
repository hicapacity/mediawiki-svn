<?php
/**
 * Internationalisation file for extension CodeReview.
 *
 * @file
 * @ingroup Extensions
 */

$messages = array();

$messages['en'] = array(
	'code' => 'Code Review',
	'code-comments' => 'Comments',
	'code-desc' => '[[Special:Code|Code review tool]] with [[Special:RepoAdmin|Subversion support]]',
	'code-no-repo' => 'No repository configured!',
	'code-comments' => 'Review notes',
	'code-authors' => 'authors',
	'code-tags' => 'tags',
	'code-authors-text' => 'Below is a list of repo authors in order of recent commits.',
	'code-author-haslink' => 'This author is linked to the wiki user $1',
	'code-author-orphan' => 'This author has no link with a wiki account',
	'code-author-dolink' => 'Link this author to a wiki user:',
	'code-author-alterlink' => 'Change the wiki user linked to this author:',
	'code-author-orunlink' => 'Or unlink this wiki user:',
	'code-author-name' => 'Enter a username:',
	'code-author-success' => 'The author $1 has been linked to the wiki user $2',
	'code-author-link' => 'link?',
	'code-author-unlink' => 'unlink?',
	'code-author-unlinksuccess' => 'Author $1 has been unlinked',
	'code-field-id' => 'Revision',
	'code-field-author' => 'Author',
	'code-field-user' => 'Commentor',
	'code-field-message' => 'Commit summary',
	'code-field-status' => 'Status',
	'code-field-timestamp' => 'Date',
	'code-field-comments' => 'Notes',
	'code-field-path' => 'Path',
	'code-field-text' => 'Note',
	'code-rev-author' => 'Author:',
	'code-rev-message' => 'Comment:',
	'code-rev-repo' => 'Repository:',
	'code-rev-rev' => 'Revision:',
	'code-rev-rev-viewvc' => 'on ViewVC',
	'code-rev-paths' => 'Modified paths:',
	'code-rev-modified-a' => 'added',
	'code-rev-modified-r' => 'replaced',
	'code-rev-modified-d' => 'deleted',
	'code-rev-modified-m' => 'modified',
	'code-rev-status' => 'Status:',
	'code-rev-status-set' => 'Change status',
	'code-rev-tags' => 'Tags:',
	'code-rev-tag-add' => 'Add tags:',
	'code-rev-tag-remove' => 'Remove tags:',
	'code-rev-comment-by' => 'Comment by $1',
	'code-rev-comment-submit' => 'Submit comment',
	'code-rev-comment-preview' => 'Preview',
	'code-rev-diff' => 'Diff',
	'code-rev-diff-link' => 'diff',
	'code-status-new' => 'new',
	'code-status-fixme' => 'fixme',
	'code-status-resolved' => 'resolved',
	'code-status-ok' => 'ok',
	'code-rev-submit' => 'Commit changes',
	
	'codereview-reply-link' => 'reply',

	'repoadmin' => 'Repository Administration',
	'repoadmin-new-legend' => 'Create a new repository',
	'repoadmin-new-label' => 'Repository name:',
	'repoadmin-new-button' => 'Create',
	'repoadmin-edit-legend' => 'Modification of repository "$1"',
	'repoadmin-edit-path' => 'Repository path:',
	'repoadmin-edit-bug' => 'Bugzilla path:',
	'repoadmin-edit-view' => 'ViewVC path:',
	'repoadmin-edit-button' => 'OK',
	'repoadmin-edit-sucess' => 'The repository "[[Special:Code/$1|$1]]" has been successfully modified.',

	'right-repoadmin' => 'Manage code repositories',
	'right-codereview-add-tag' => 'Add new tags to revisions',
	'right-codereview-remove-tag' => 'Remove tags from revisions',
	'right-codereview-post-comment' => 'Add comments on revisions',
	'right-codereview-set-status' => 'Change revisions status',
	
	'specialpages-group-developer' => 'Developer tools',
);

/** Message documentation (Message documentation)
 * @author EugeneZelenko
 */
$messages['qqq'] = array(
	'code-comments' => '{{Identical|Comments}}',
	'code-field-author' => '{{Identical|Author}}',
	'code-field-message' => '{{Identical|Comment}}',
	'code-field-comments' => '{{Identical|Notes}}',
	'code-rev-author' => '{{Identical|Author}}',
	'code-rev-message' => '{{Identical|Comment}}',
	'code-rev-comment-preview' => '{{Identical|Preview}}',
	'repoadmin-new-button' => '{{Identical|Create}}',
	'repoadmin-edit-button' => '{{Identical|OK}}',
);

/** Arabic (العربية)
 * @author Meno25
 */
$messages['ar'] = array(
	'code' => 'مراجعة الكود',
	'code-comments' => 'تعليقات',
	'code-desc' => '[[Special:Code|أداة مراجعة الكود]] مع [[Special:RepoAdmin|دعم ساب فيرجن]]',
	'code-no-repo' => 'لا مستودع تم ضبطه!',
	'code-author-haslink' => 'هذا المؤلف موصول بمستخدم الويكي $1',
	'code-author-orphan' => 'هذا المؤلف ليس له وصلة لحساب ويكي',
	'code-author-dolink' => 'صل هذا المؤلف بمستخدم ويكي :',
	'code-author-alterlink' => 'غير مستخدم الويكي الموصول لهذا المؤلف:',
	'code-author-orunlink' => 'أو أزل وصل مستخدم الويكي هذا:',
	'code-author-name' => 'أدخل اسم مستخدم:',
	'code-author-success' => 'المؤلف $1 تم وصله بنجاح بمستخدم الويكي $2',
	'code-author-link' => 'وصلة؟',
	'code-author-unlink' => 'أزل الوصلة؟',
	'code-author-unlinksuccess' => 'المؤلف $1 تمت إزالة وصله',
	'code-field-id' => 'مراجعة',
	'code-field-author' => 'مؤلف',
	'code-field-message' => 'تعليق',
	'code-field-status' => 'حالة',
	'code-field-timestamp' => 'تاريخ',
	'code-field-comments' => 'ملاحظات',
	'code-rev-author' => 'مؤلف:',
	'code-rev-message' => 'تعليق:',
	'code-rev-repo' => 'مستودع:',
	'code-rev-rev' => 'مراجعة:',
	'code-rev-rev-viewvc' => 'على فيو في سي',
	'code-rev-paths' => 'مسارات معدلة:',
	'code-rev-modified-a' => 'تمت إضافته',
	'code-rev-modified-r' => 'تم استبداله',
	'code-rev-modified-d' => 'تم حذفه',
	'code-rev-modified-m' => 'تم تعديله',
	'code-rev-status' => 'حالة:',
	'code-rev-status-set' => 'تغيير الحالة',
	'code-rev-tags' => 'وسوم:',
	'code-rev-tag-add' => 'إضافة وسوم:',
	'code-rev-tag-remove' => 'أزل الوسوم:',
	'code-rev-comment-by' => 'تعليق بواسطة $1',
	'code-rev-comment-submit' => 'إرسال التعليق',
	'code-rev-comment-preview' => 'عرض مسبق',
	'code-rev-diff' => 'فرق',
	'code-rev-diff-link' => 'فرق',
	'code-status-new' => 'جديد',
	'code-status-fixme' => 'أصلحني',
	'code-status-resolved' => 'تم حلها',
	'code-status-ok' => 'موافق',
	'code-rev-submit' => 'تنفيذ التغييرات',
	'codereview-reply-link' => 'رد',
	'repoadmin' => 'إدارة المستودع',
	'repoadmin-new-legend' => 'إنشاء مستودع جديد',
	'repoadmin-new-label' => 'اسم المستودع:',
	'repoadmin-new-button' => 'إنشاء',
	'repoadmin-edit-legend' => 'تعديل المستودع "$1"',
	'repoadmin-edit-path' => 'مسار المستودع:',
	'repoadmin-edit-bug' => 'مسار بجزيللا:',
	'repoadmin-edit-view' => 'مسار فيو في سي:',
	'repoadmin-edit-button' => 'موافق',
	'repoadmin-edit-sucess' => 'المستودع "[[Special:Code/$1|$1]]" تم تعديله بنجاح.',
	'right-repoadmin' => 'التحكم بمستودعات الكود',
	'right-codereview-add-tag' => 'إضافة وسوم جديدة للمراجعات',
	'right-codereview-remove-tag' => 'إزالة الوسوم من المراجعات',
	'right-codereview-post-comment' => 'إضافة تعليقات على المراجعات',
	'right-codereview-set-status' => 'تغيير حالة المراجعات',
);

/** Egyptian Spoken Arabic (مصرى)
 * @author Meno25
 */
$messages['arz'] = array(
	'code' => 'مراجعة الكود',
	'code-comments' => 'تعليقات',
	'code-desc' => '[[Special:Code|أداة مراجعة الكود]] مع [[Special:RepoAdmin|دعم ساب فيرجن]]',
	'code-no-repo' => 'لا مستودع تم ضبطه!',
	'code-author-haslink' => 'هذا المؤلف موصول بمستخدم الويكى $1',
	'code-author-orphan' => 'هذا المؤلف ليس له وصلة لحساب ويكى',
	'code-author-dolink' => 'صل هذا المؤلف بمستخدم ويكى :',
	'code-author-alterlink' => 'غير مستخدم الويكى الموصول لهذا المؤلف:',
	'code-author-orunlink' => 'أو أزل وصل مستخدم الويكى هذا:',
	'code-author-name' => 'أدخل اسم مستخدم:',
	'code-author-success' => 'المؤلف $1 تم وصله بنجاح بمستخدم الويكى $2',
	'code-author-link' => 'وصلة؟',
	'code-author-unlink' => 'أزل الوصلة؟',
	'code-author-unlinksuccess' => 'المؤلف $1 تمت إزالة وصله',
	'code-field-id' => 'مراجعة',
	'code-field-author' => 'مؤلف',
	'code-field-message' => 'تعليق',
	'code-field-status' => 'حالة',
	'code-field-timestamp' => 'تاريخ',
	'code-field-comments' => 'ملاحظات',
	'code-rev-author' => 'مؤلف:',
	'code-rev-message' => 'تعليق:',
	'code-rev-repo' => 'مستودع:',
	'code-rev-rev' => 'مراجعة:',
	'code-rev-rev-viewvc' => 'على فيو فى سى',
	'code-rev-paths' => 'مسارات معدلة:',
	'code-rev-modified-a' => 'تمت إضافته',
	'code-rev-modified-r' => 'تم استبداله',
	'code-rev-modified-d' => 'تم حذفه',
	'code-rev-modified-m' => 'تم تعديله',
	'code-rev-status' => 'حالة:',
	'code-rev-status-set' => 'تغيير الحالة',
	'code-rev-tags' => 'وسوم:',
	'code-rev-tag-add' => 'إضافة وسوم:',
	'code-rev-tag-remove' => 'أزل الوسوم:',
	'code-rev-comment-by' => 'تعليق بواسطة $1',
	'code-rev-comment-submit' => 'إرسال التعليق',
	'code-rev-comment-preview' => 'عرض مسبق',
	'code-rev-diff' => 'فرق',
	'code-rev-diff-link' => 'فرق',
	'code-status-new' => 'جديد',
	'code-status-fixme' => 'أصلحنى',
	'code-status-resolved' => 'تم حلها',
	'code-status-ok' => 'موافق',
	'code-rev-submit' => 'تنفيذ التغييرات',
	'codereview-reply-link' => 'رد',
	'repoadmin' => 'إدارة المستودع',
	'repoadmin-new-legend' => 'إنشاء مستودع جديد',
	'repoadmin-new-label' => 'اسم المستودع:',
	'repoadmin-new-button' => 'إنشاء',
	'repoadmin-edit-legend' => 'تعديل المستودع "$1"',
	'repoadmin-edit-path' => 'مسار المستودع:',
	'repoadmin-edit-bug' => 'مسار بجزيللا:',
	'repoadmin-edit-view' => 'مسار فيو فى سى:',
	'repoadmin-edit-button' => 'موافق',
	'repoadmin-edit-sucess' => 'المستودع "[[Special:Code/$1|$1]]" تم تعديله بنجاح.',
	'right-repoadmin' => 'التحكم بمستودعات الكود',
	'right-codereview-add-tag' => 'إضافة وسوم جديدة للمراجعات',
	'right-codereview-remove-tag' => 'إزالة الوسوم من المراجعات',
	'right-codereview-post-comment' => 'إضافة تعليقات على المراجعات',
	'right-codereview-set-status' => 'تغيير حالة المراجعات',
);

/** Belarusian (Taraškievica orthography) (Беларуская (тарашкевіца))
 * @author EugeneZelenko
 */
$messages['be-tarask'] = array(
	'code-comments' => 'Камэнтары',
	'code-field-id' => 'Вэрсія',
	'code-field-author' => 'Аўтар',
	'code-field-message' => 'Камэнтар',
	'code-rev-author' => 'Аўтар:',
	'code-rev-message' => 'Камэнтар:',
	'code-rev-comment-preview' => 'Прагляд',
	'repoadmin-new-button' => 'Стварыць',
	'repoadmin-edit-button' => 'Добра',
);

/** German (Deutsch) */
$messages['de'] = array(
	'code' => 'Codeprüfung',
	'code-comments' => 'Kommentare',
	'code-desc' => '[[Special:Code|Codeprüfungs-Werkzeug]] mit [[Special:RepoAdmin|Subversion-Unterstützung]]',
	'code-no-repo' => 'Kein Repositorium konfiguriert.',
	'code-field-id' => 'Revision',
	'code-field-author' => 'Autor',
	'code-field-message' => 'Kommentar',
	'code-field-status' => 'Status',
	'code-field-timestamp' => 'Datum',
	'code-rev-author' => 'Autor:',
	'code-rev-message' => 'Kommentar:',
	'code-rev-repo' => 'Repositorium:',
	'code-rev-rev' => 'Revision:',
	'code-rev-rev-viewvc' => 'auf ViewVC',
	'code-rev-paths' => 'Geänderte Pfade:',
	'code-rev-modified-a' => 'hinzugefügt',
	'code-rev-modified-d' => 'gelöscht',
	'code-rev-modified-m' => 'geändert',
	'code-rev-status' => 'Status:',
	'code-rev-status-set' => 'Status ändern',
	'code-rev-tags' => 'Tags:',
	'code-rev-tag-add' => 'Ergänze Tag',
	'code-rev-comment-by' => 'Kommentar von $1',
	'code-rev-comment-submit' => 'Kommentar abschicken',
	'code-rev-comment-preview' => 'Vorschau',
	'code-rev-diff' => 'Diff',
	'code-rev-diff-link' => 'Diff',
	'code-status-new' => 'neu',
	'code-status-fixme' => 'fixme',
	'code-status-resolved' => 'erledigt',
	'code-status-ok' => 'OK',
	'codereview-reply-link' => 'antworten',
	'repoadmin' => 'Repositoriums-Administration',
	'repoadmin-new-legend' => 'Neues Repositorium erstellen',
	'repoadmin-new-label' => 'Name des Repositoriums:',
	'repoadmin-new-button' => 'Erstellen',
	'repoadmin-edit-legend' => 'Änderungen am Repositorium „$1“',
	'repoadmin-edit-path' => 'Pfad zum Repositorium:',
	'repoadmin-edit-bug' => 'Pfad zu Bugzilla:',
	'repoadmin-edit-view' => 'Pfad zu ViewVC:',
	'repoadmin-edit-button' => 'OK',
	'repoadmin-edit-sucess' => 'Das Repositorium „[[Special:Code/$1|$1]]“ wurde erfolgreich geändert.',
	'right-repoadmin' => 'Code-Repositorien verwalten',
	'right-codereview-add-tag' => 'Hinzufügen neuer Tags zu Revisionen',
	'right-codereview-remove-tag' => 'Entfernen von Tags von Revisionen',
	'right-codereview-post-comment' => 'Ergänzen von Kommentare zu Revisionen',
	'right-codereview-set-status' => 'Ändern des Revisionsstatus',
);

/** Esperanto (Esperanto)
 * @author Yekrats
 */
$messages['eo'] = array(
	'code-field-id' => 'Revizio',
	'code-field-author' => 'Aŭtoro',
	'code-field-message' => 'Komento',
	'code-field-status' => 'Statuso',
	'code-field-timestamp' => 'Dato',
	'code-rev-author' => 'Aŭtoro:',
	'code-rev-message' => 'Komento:',
	'code-rev-rev' => 'Revizio:',
	'code-rev-modified-a' => 'aldonis',
	'code-rev-modified-d' => 'forigis',
	'code-rev-modified-m' => 'modifis',
	'code-rev-status' => 'Statuso:',
	'code-rev-status-set' => 'Ŝanĝi statuson',
	'code-rev-tags' => 'Etikedoj:',
	'code-rev-tag-add' => 'Aldoni etikedon',
	'code-rev-comment-submit' => 'Enmeti komenton',
	'code-rev-comment-preview' => 'Antaŭrigardi',
	'code-status-new' => 'nova',
	'codereview-reply-link' => 'respondo',
);

/** French (Français)
 * @author Cedric31
 * @author IAlex
 */
$messages['fr'] = array(
	'code' => 'Vérification du code',
	'code-comments' => 'Commentaires',
	'code-desc' => '[[Special:Code|Outils pour revoir le code]] avec [[Special:RepoAdmin|support de Subversion]]',
	'code-no-repo' => 'Pas de dépôt configuré !',
	'code-author-haslink' => 'Cet auteur est lié au compte $1 de ce wiki',
	'code-author-dolink' => 'Associer cet auteur à un compte wiki local :',
	'code-author-name' => "Entrez un nom d'utilisateur :",
	'code-field-id' => 'Révision',
	'code-field-author' => 'Auteur',
	'code-field-message' => 'Commentaire',
	'code-field-status' => 'Statut',
	'code-field-timestamp' => 'Date',
	'code-rev-author' => 'Auteur :',
	'code-rev-message' => 'Commentaire :',
	'code-rev-repo' => 'Dépôt :',
	'code-rev-rev' => 'Révision :',
	'code-rev-rev-viewvc' => 'sur ViewVC',
	'code-rev-paths' => 'Fichiers/dossiers modifiés :',
	'code-rev-modified-a' => 'ajouté',
	'code-rev-modified-d' => 'supprimé',
	'code-rev-modified-m' => 'modifié',
	'code-rev-status' => 'Statut :',
	'code-rev-status-set' => 'Changer le statut',
	'code-rev-tags' => 'Attributs :',
	'code-rev-tag-add' => "Ajouter l'attribut",
	'code-rev-comment-by' => 'Commentaire par $1',
	'code-rev-comment-submit' => 'Ajouter le commentaire',
	'code-rev-comment-preview' => 'Prévisualisation',
	'code-rev-diff' => 'Différence',
	'code-rev-diff-link' => 'diff',
	'code-status-new' => 'nouveau',
	'code-status-fixme' => 'a réparer',
	'code-status-resolved' => 'résolu',
	'code-status-ok' => 'ok',
	'codereview-reply-link' => 'répondre',
	'repoadmin' => 'Administration des dépôts',
	'repoadmin-new-legend' => 'Créer un nouveau dépôt',
	'repoadmin-new-label' => 'Nom du dépôt:',
	'repoadmin-new-button' => 'Créer',
	'repoadmin-edit-legend' => 'Modification du dépôt "$1"',
	'repoadmin-edit-path' => 'Chemin du dépôt :',
	'repoadmin-edit-bug' => 'Chemin de Bugzilla :',
	'repoadmin-edit-view' => 'Chemin de ViewVC :',
	'repoadmin-edit-button' => 'Valider',
	'repoadmin-edit-sucess' => 'Le dépôt "[[Special:Code/$1|$1]]" a été modifié avec succès.',
	'right-repoadmin' => 'Administrer les dépôts de code',
	'right-codereview-add-tag' => 'Ajouter de nouveaux attributs aux révision',
	'right-codereview-remove-tag' => 'Enlever de attributs aux révision',
	'right-codereview-post-comment' => 'Ajouter un commentaire aux révisions',
	'right-codereview-set-status' => 'Changer le statut des revisions',
);

/** Galician (Galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'code' => 'Revisión do código',
	'code-comments' => 'Comentarios',
	'code-desc' => '[[Special:Code|Ferramenta de revisión do código]] con [[Special:RepoAdmin|apoio da subversión]]',
	'code-no-repo' => 'Non hai ningún repositorio configurado!',
	'code-author-haslink' => 'O autor é ligado co usuario do wiki chamado $1',
	'code-author-dolink' => 'Ligar este autor cun usuario do wiki:',
	'code-author-name' => 'Insira un nome de usuario:',
	'code-author-success' => 'O autor $1 foi ligado con éxito ao usuario do wiki $2',
	'code-field-id' => 'Revisión',
	'code-field-author' => 'Autor',
	'code-field-message' => 'Comentario',
	'code-field-status' => 'Status',
	'code-field-timestamp' => 'Data',
	'code-field-comments' => 'Notas',
	'code-rev-author' => 'Autor:',
	'code-rev-message' => 'Comentario:',
	'code-rev-repo' => 'Repositorio:',
	'code-rev-rev' => 'Revisión:',
	'code-rev-rev-viewvc' => 'en ViewVC',
	'code-rev-paths' => 'Rutas modificadas:',
	'code-rev-modified-a' => 'engadiu',
	'code-rev-modified-r' => 'substituíu',
	'code-rev-modified-d' => 'borrou',
	'code-rev-modified-m' => 'modificou',
	'code-rev-status' => 'Status:',
	'code-rev-status-set' => 'Cambiar o status',
	'code-rev-tags' => 'Etiquetas:',
	'code-rev-tag-add' => 'Engadir as etiquetas',
	'code-rev-comment-by' => 'Comentario de $1',
	'code-rev-comment-submit' => 'Enviar o comentario',
	'code-rev-comment-preview' => 'Vista previa',
	'code-rev-diff' => 'Dif',
	'code-rev-diff-link' => 'dif',
	'code-status-new' => 'novo',
	'code-status-fixme' => 'arránxame',
	'code-status-resolved' => 'resolto',
	'code-status-ok' => 'de acordo',
	'codereview-reply-link' => 'resposta',
	'repoadmin' => 'Administración do repositorio',
	'repoadmin-new-legend' => 'Crear un novo repositorio',
	'repoadmin-new-label' => 'Nome do repositorio:',
	'repoadmin-new-button' => 'Crear',
	'repoadmin-edit-legend' => 'Modificación do repositorio "$1"',
	'repoadmin-edit-path' => 'Ruta do repositorio:',
	'repoadmin-edit-bug' => 'Ruta Bugzilla:',
	'repoadmin-edit-view' => 'Ruta ViewVC:',
	'repoadmin-edit-button' => 'De acordo',
	'repoadmin-edit-sucess' => 'O repositorio "[[Special:Code/$1|$1]]" foi modificado con éxito.',
	'right-repoadmin' => 'Xestionar o código dos repositorios',
	'right-codereview-add-tag' => 'Engadir etiquetas novas ás revisións',
	'right-codereview-remove-tag' => 'Eliminar as etiquetas das revisións',
	'right-codereview-post-comment' => 'Engadir comentarios ás revisións',
	'right-codereview-set-status' => 'Cambiar o status das revisións',
);

/** Hungarian (Magyar)
 * @author Dani
 */
$messages['hu'] = array(
	'code' => 'Kódellenőrzés',
	'code-comments' => 'Hozzászólások',
	'code-desc' => '[[Special:Code|Kódellenőrző eszköz]] [[Special:RepoAdmin|Subversion-támogatással]]',
	'code-no-repo' => 'Nincs repository beállítva!',
	'code-author-haslink' => 'Ez a szerző megegyezi a wiki $1 nevű szerkesztőjével',
	'code-author-orphan' => 'Ez a szerkesztő nem rendelkezik felhasználói fiókkal ezen a wikin',
	'code-author-dolink' => 'Szerző összekapcsolása a wiki egyik szerkesztőjével:',
	'code-author-alterlink' => 'A szerzőhöz kapcsolt felhasználói fiók megváltoztatása:',
	'code-author-orunlink' => 'A szerkesztő leválasztása a szerzőről:',
	'code-author-name' => 'Adj meg egy felhasználói nevet:',
	'code-author-success' => '$1 össze lett kapcsolva a wiki $2 nevű szerkesztőjével',
	'code-field-id' => 'Változat',
	'code-field-author' => 'Szerző',
	'code-field-message' => 'Megjegyzés',
	'code-field-status' => 'Állapot',
	'code-field-timestamp' => 'Időpont',
	'code-field-comments' => 'Hozzászólások',
	'code-rev-author' => 'Szerző:',
	'code-rev-message' => 'Megjegyzés:',
	'code-rev-rev' => 'Változat:',
	'code-rev-rev-viewvc' => 'a ViewVC-n',
	'code-rev-paths' => 'Módosított elemek:',
	'code-rev-modified-a' => 'hozzáadva',
	'code-rev-modified-r' => 'cserélve',
	'code-rev-modified-d' => 'törölve',
	'code-rev-modified-m' => 'módosítva',
	'code-rev-status' => 'Állapot:',
	'code-rev-status-set' => 'Állapot módosítása',
	'code-rev-tags' => 'Címkék:',
	'code-rev-tag-add' => 'Címkék hozzáadása:',
	'code-rev-tag-remove' => 'Címkék eltávolítása:',
	'code-rev-comment-by' => '$1 hozzászólása',
	'code-rev-comment-submit' => 'Hozzászólás elküldése',
	'code-rev-comment-preview' => 'Előnézet',
	'code-status-new' => 'új',
	'code-status-fixme' => 'javítandó',
	'code-status-resolved' => 'javítva',
	'code-status-ok' => 'rendben',
	'code-rev-submit' => 'Változások elküldése',
	'codereview-reply-link' => 'válasz',
	'right-codereview-add-tag' => 'új címkék hozzáadása az egyes változatokhoz',
	'right-codereview-remove-tag' => 'címkék eltávolítása változatokról',
	'right-codereview-post-comment' => 'hozzászólás az egyes változatokhoz',
	'right-codereview-set-status' => 'változat állapotának megváltoztatása',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'code' => 'Revision de codice',
	'code-comments' => 'Commentos',
	'code-desc' => '[[Special:Code|Instrumento pro revider le codice]] con [[Special:RepoAdmin|supporto de Subversion]]',
	'code-no-repo' => 'Nulle repositorio configurate!',
	'code-field-id' => 'Version',
	'code-field-author' => 'Autor',
	'code-field-message' => 'Commento',
	'code-field-status' => 'Stato',
	'code-field-timestamp' => 'Data',
	'code-rev-author' => 'Autor:',
	'code-rev-message' => 'Commento:',
	'code-rev-repo' => 'Repositorio:',
	'code-rev-rev' => 'Version:',
	'code-rev-rev-viewvc' => 'in ViewVC',
	'code-rev-paths' => 'Camminos modificate:',
	'code-rev-modified-a' => 'addite',
	'code-rev-modified-d' => 'delite',
	'code-rev-modified-m' => 'modificate',
	'code-rev-status' => 'Stato:',
	'code-rev-status-set' => 'Cambiar stato',
	'code-rev-tags' => 'Etiquettas:',
	'code-rev-tag-add' => 'Adder etiquetta',
	'code-rev-comment-by' => 'Commento per $1',
	'code-rev-comment-submit' => 'Submitter commento',
	'code-rev-comment-preview' => 'Previsualisation',
	'code-rev-diff' => 'Diff',
	'code-rev-diff-link' => 'diff',
	'code-status-new' => 'nove',
	'code-status-fixme' => 'a reparar',
	'code-status-resolved' => 'resolvite',
	'code-status-ok' => 'ok',
	'codereview-reply-link' => 'responder',
	'repoadmin' => 'Administration del repositorios',
	'repoadmin-new-legend' => 'Crear un nove repositorio',
	'repoadmin-new-label' => 'Nomine del repositorio:',
	'repoadmin-new-button' => 'Crear',
	'repoadmin-edit-legend' => 'Modification del repositorio "$1"',
	'repoadmin-edit-path' => 'Cammino del repositorio:',
	'repoadmin-edit-bug' => 'Cammino de Bugzilla:',
	'repoadmin-edit-view' => 'Cammino de ViewVC:',
	'repoadmin-edit-button' => 'OK',
	'repoadmin-edit-sucess' => 'Le repositorio "[[Special:Code/$1|$1]]" ha essite modificate con successo.',
	'right-repoadmin' => 'Administrar le repositorios de codice',
	'right-codereview-add-tag' => 'Adder nove etiquettas a versiones',
	'right-codereview-remove-tag' => 'Remover etiquettas de versiones',
	'right-codereview-post-comment' => 'Adder commentos a versiones',
	'right-codereview-set-status' => 'Cambiar le stato de versiones',
);

/** Italian (Italiano)
 * @author Darth Kule
 */
$messages['it'] = array(
	'code-comments' => 'Commenti',
	'code-author-haslink' => 'Questo autore è collegato al wiki utente $1',
	'code-author-orphan' => 'Questo autore non è collegato a un account wiki',
	'code-author-dolink' => 'Collegare questo autore a un utente wiki:',
	'code-author-alterlink' => "Cambiare l'utente wiki collegato a questo autore:",
	'code-author-orunlink' => 'O rimuovere il collegamento con questo utente wiki:',
	'code-author-name' => 'Inserire un nome utente:',
	'code-author-success' => "L'autore $1 è stato collegato all'utente wiki $2",
	'code-author-unlinksuccess' => "È stato rimosso il collegamento all'autore",
	'code-field-id' => 'Revisione',
	'code-field-author' => 'Autore',
	'code-field-message' => 'Commento',
	'code-field-status' => 'Stato',
	'code-field-timestamp' => 'Data',
	'code-field-comments' => 'Note',
	'code-rev-author' => 'Autore:',
	'code-rev-message' => 'Commento:',
	'code-rev-rev' => 'Revisione:',
	'code-rev-rev-viewvc' => 'su ViewVC',
	'code-rev-modified-a' => 'aggiunto',
	'code-rev-modified-r' => 'sostituito',
	'code-rev-modified-d' => 'cancellato',
	'code-rev-modified-m' => 'modificato',
	'code-rev-status' => 'Stato:',
	'code-rev-status-set' => 'Modifica stato',
	'code-rev-tags' => 'Tag:',
	'code-rev-tag-add' => 'Aggiungi tag:',
	'code-rev-tag-remove' => 'Rimuovi tag:',
	'code-rev-comment-by' => 'Commento di $1',
	'code-rev-comment-submit' => 'Invia commento',
	'code-rev-comment-preview' => 'Anteprima',
	'code-rev-diff' => 'Diff',
	'code-rev-diff-link' => 'diff',
	'codereview-reply-link' => 'rispondi',
	'repoadmin-new-button' => 'Crea',
	'repoadmin-edit-button' => 'OK',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'code-comments' => 'Bemierkungen',
	'code-author-name' => 'Gitt e Benotzernmm an:',
	'code-field-author' => 'Auteur',
	'code-field-message' => 'Bemierkung',
	'code-field-status' => 'Status',
	'code-field-timestamp' => 'Datum',
	'code-field-comments' => 'Notizen',
	'code-rev-author' => 'Auteur:',
	'code-rev-message' => 'Bemierkung:',
	'code-rev-modified-r' => 'ersat',
	'code-rev-modified-d' => 'geläscht',
	'code-rev-modified-m' => 'geännert',
	'code-rev-status' => 'Status:',
	'code-rev-status-set' => 'Status änneren',
	'code-rev-comment-by' => 'Bemierkung vum $1',
	'code-rev-comment-preview' => 'Kucken ouni ze späicheren',
	'code-status-new' => 'nei',
	'code-status-resolved' => 'geléist',
	'code-status-ok' => 'ok',
	'codereview-reply-link' => 'äntwerten',
	'repoadmin-new-button' => 'Uleeën',
	'repoadmin-edit-button' => 'OK',
);

/** Dutch (Nederlands)
 * @author Siebrand
 */
$messages['nl'] = array(
	'code' => 'Codecontrole',
	'code-comments' => 'Opmerkingen bij beoordeling',
	'code-desc' => '[[Special:Code|Hulpprogramma voor codecontrole]] met [[Special:RepoAdmin|ondersteuning voor Subversion]]',
	'code-no-repo' => 'Er is geen repository ingesteld!',
	'code-authors' => 'auteurs',
	'code-tags' => 'labels',
	'code-authors-text' => 'Hieronder staat een lijst met auteurs uit de repository, degene met de meest recente commit bovenaan.',
	'code-author-haslink' => 'Deze auteur is gekoppeld aan de wikigebruiker $1',
	'code-author-orphan' => 'Deze auteur is niet gekoppeld aan een wikigebruiker',
	'code-author-dolink' => 'Deze auteur met een wikigebruiker koppelen:',
	'code-author-alterlink' => 'De aan deze auteur gekoppelde wikigebruiker wijzigen:',
	'code-author-orunlink' => 'Of deze wikigebruiker ontkoppelen:',
	'code-author-name' => 'Geef een gebruikersnaam in:',
	'code-author-success' => 'De auteur $1 is gekoppeld aan de wikigebruiker $2',
	'code-author-link' => 'koppelen?',
	'code-author-unlink' => 'ontkoppelen?',
	'code-author-unlinksuccess' => 'De auteur $1 is ontkoppeld.',
	'code-field-id' => 'Versie',
	'code-field-author' => 'Auteur',
	'code-field-user' => 'Opmerking door:',
	'code-field-message' => 'Toelichting bij commit',
	'code-field-status' => 'Status',
	'code-field-timestamp' => 'Datum',
	'code-field-comments' => 'Aantekeningen',
	'code-field-path' => 'Pad',
	'code-field-text' => 'Opmerking',
	'code-rev-author' => 'Auteur:',
	'code-rev-message' => 'Opmerking:',
	'code-rev-repo' => 'Repository:',
	'code-rev-rev' => 'Versie:',
	'code-rev-rev-viewvc' => 'in ViewVC',
	'code-rev-paths' => 'Gewijzigde bestanden:',
	'code-rev-modified-a' => 'toegevoegd',
	'code-rev-modified-r' => 'vervangen',
	'code-rev-modified-d' => 'verwijderd',
	'code-rev-modified-m' => 'gewijzigd',
	'code-rev-status' => 'Status:',
	'code-rev-status-set' => 'Wijzigingsstatus',
	'code-rev-tags' => 'Labels:',
	'code-rev-tag-add' => 'Labels toevoegen:',
	'code-rev-tag-remove' => 'Labels verwijderen:',
	'code-rev-comment-by' => 'Opmerking van $1',
	'code-rev-comment-submit' => 'Opmerking opslaan',
	'code-rev-comment-preview' => 'Nakijken',
	'code-rev-diff' => 'Verschil',
	'code-rev-diff-link' => 'verschil',
	'code-status-new' => 'nieuw',
	'code-status-fixme' => 'fixme',
	'code-status-resolved' => 'opgelost',
	'code-status-ok' => 'ok',
	'code-rev-submit' => 'Wijzigingen committen',
	'codereview-reply-link' => 'antwoorden',
	'repoadmin' => 'Repositorybeheer',
	'repoadmin-new-legend' => 'Nieuwe repository instellen',
	'repoadmin-new-label' => 'Repositorynaam:',
	'repoadmin-new-button' => 'Aanmaken',
	'repoadmin-edit-legend' => 'Wijziging aan repository "$1"',
	'repoadmin-edit-path' => 'Repositorypad:',
	'repoadmin-edit-bug' => 'Bugzilla-pad:',
	'repoadmin-edit-view' => 'ViewVC-pad:',
	'repoadmin-edit-button' => 'OK',
	'repoadmin-edit-sucess' => 'De repository "[[Special:Code/$1|$1]] is aangepast.',
	'right-repoadmin' => 'Coderepositories beheren',
	'right-codereview-add-tag' => 'Labels toevoegen aan versies',
	'right-codereview-remove-tag' => 'Labels verwijderen van versies',
	'right-codereview-post-comment' => 'Opmerkingen toevoegen aan versies',
	'right-codereview-set-status' => 'Versiestatus wijzigen',
	'specialpages-group-developer' => 'Hulpmiddelen voor ontwikkelaars',
);

/** Occitan (Occitan)
 * @author Cedric31
 */
$messages['oc'] = array(
	'code' => 'Verificacion del còde',
	'code-comments' => 'Comentaris',
	'code-desc' => '[[Special:Code|Espleches per tornar veire lo còde]] amb [[Special:RepoAdmin|supòrt de Subversion]]',
	'code-no-repo' => 'Pas de depaus configurat !',
	'code-field-id' => 'Revision',
	'code-field-author' => 'Autor',
	'code-field-message' => 'Comentari',
	'code-field-status' => 'Estatut',
	'code-field-timestamp' => 'Data',
	'code-rev-author' => 'Autor :',
	'code-rev-message' => 'Comentari :',
	'code-rev-repo' => 'Depaus :',
	'code-rev-rev' => 'Revision :',
	'code-rev-rev-viewvc' => 'sus ViewVC',
	'code-rev-paths' => 'Fichièrs/dorsièrs modificats :',
	'code-rev-modified-a' => 'apondut',
	'code-rev-modified-d' => 'suprimit',
	'code-rev-modified-m' => 'modificat',
	'code-rev-status' => 'Estatut :',
	'code-rev-status-set' => "Cambiar l'estatut",
	'code-rev-tags' => 'Atributs :',
	'code-rev-tag-add' => "Apondre l'atribut",
	'code-rev-comment-by' => 'Comentari per $1',
	'code-rev-comment-submit' => 'Apondre lo comentari',
	'code-rev-comment-preview' => 'Previsualizacion',
	'code-rev-diff' => 'Dif',
	'code-rev-diff-link' => 'dif',
	'code-status-new' => 'novèl',
	'code-status-fixme' => 'de reparar',
	'code-status-resolved' => 'resolgut',
	'code-status-ok' => "d'acòrdi",
	'codereview-reply-link' => 'respondre',
	'repoadmin' => 'Administracion dels depausses',
	'repoadmin-new-legend' => 'Crear un depaus novèl',
	'repoadmin-new-label' => 'Nom del depaus :',
	'repoadmin-new-button' => 'Crear',
	'repoadmin-edit-legend' => 'Modificacion del depaus "$1"',
	'repoadmin-edit-path' => 'Camin del depaus :',
	'repoadmin-edit-bug' => 'Camin de Bugzilla :',
	'repoadmin-edit-view' => 'Camin de ViewVC :',
	'repoadmin-edit-button' => "D'acòrdi",
	'repoadmin-edit-sucess' => 'Lo depaux "[[Special:Code/$1|$1]]" es estat modificat amb succès.',
	'right-repoadmin' => 'Administrar los depausses de còde',
	'right-codereview-add-tag' => "Apondre d'atributs novèls a las revisions",
	'right-codereview-remove-tag' => "Levar d'atributs a las revisions",
	'right-codereview-post-comment' => 'Apondre un comentari a las revisions',
	'right-codereview-set-status' => "Cambiar l'estatut de las revisions",
);

/** Russian (Русский)
 * @author Kaganer
 */
$messages['ru'] = array(
	'code' => 'Обзор изменений программного кода (Code Review)',
	'code-comments' => 'Комментарии',
	'code-desc' => '[[Special:Code|Инструмент для просмотра и комментирования изменений программного кода]] (Code Review) с [[Special:RepoAdmin|поддержкой системы управления версиями]] (Subversion)',
	'code-no-repo' => 'Отсутствует настроенный репозиторий!',
	'code-field-id' => 'Редакция',
	'code-field-author' => 'Автор',
	'code-field-message' => 'Комментарий',
	'code-field-status' => 'Статус',
	'code-field-timestamp' => 'Дата',
	'code-rev-author' => 'Автор:',
	'code-rev-message' => 'Комментарий:',
	'code-rev-repo' => 'Репозиторий:',
	'code-rev-rev' => 'Редакция:',
	'code-rev-rev-viewvc' => 'через ViewVC',
	'code-rev-paths' => 'Ссылки на изменения:',
	'code-rev-modified-a' => 'добавлено',
	'code-rev-modified-d' => 'удалено',
	'code-rev-modified-m' => 'изменено',
	'code-rev-status' => 'Статус:',
	'code-rev-status-set' => 'Сменить статус',
	'code-rev-tags' => 'Метки:',
	'code-rev-tag-add' => 'Добавить метку',
	'code-rev-comment-by' => 'Комментарий от $1',
	'code-rev-comment-submit' => 'Отослать комментарий',
	'code-rev-comment-preview' => 'Предпросмотр',
	'code-rev-diff' => 'Изменение',
	'code-rev-diff-link' => 'изм.',
	'code-status-new' => 'новое',
	'code-status-fixme' => 'проверить',
	'code-status-resolved' => 'решено',
	'code-status-ok' => 'готово',
	'codereview-reply-link' => 'ответить',
	'repoadmin' => 'Управление репозиторием программного кода',
	'repoadmin-new-legend' => 'Создать новый репозиторий',
	'repoadmin-new-label' => 'Имя репозитория:',
	'repoadmin-new-button' => 'Создать',
	'repoadmin-edit-legend' => 'Изменение репозитория "$1"',
	'repoadmin-edit-path' => 'Путь к репозиторию:',
	'repoadmin-edit-bug' => 'Путь к базе Bugzilla:',
	'repoadmin-edit-view' => 'Путь к ViewVC:',
	'repoadmin-edit-button' => 'Готово',
	'repoadmin-edit-sucess' => 'Репозиторий "[[Special:Code/$1|$1]]" успешно изменён.',
	'right-repoadmin' => 'Управление кодом репозиториев',
	'right-codereview-add-tag' => 'Добавление меток для маркировки редакций',
	'right-codereview-remove-tag' => 'Удаление меток из редакций',
	'right-codereview-post-comment' => 'Добавление комментариев к редакциям',
	'right-codereview-set-status' => 'Изменение статуса редакций',
);

/** Slovak (Slovenčina)
 * @author Helix84
 */
$messages['sk'] = array(
	'code' => 'Kontrola kódu',
	'code-comments' => 'Komentáre',
	'code-desc' => '[[Special:Code|Nástroj na kontrolu kódu]] s [[Special:RepoAdmin|podporou Subversion]]',
	'code-no-repo' => 'Nebolo nastavené žiadne úložisko',
	'code-field-id' => 'Revízia',
	'code-field-author' => 'Autor',
	'code-field-message' => 'Komentár',
	'code-field-status' => 'Stav',
	'code-field-timestamp' => 'Dátum',
	'code-rev-author' => 'Autor:',
	'code-rev-message' => 'Komentár:',
	'code-rev-repo' => 'Úložisko:',
	'code-rev-rev' => 'Revízia:',
	'code-rev-rev-viewvc' => 'na ViewVC',
	'code-rev-paths' => 'Zmenené cesty:',
	'code-rev-modified-a' => 'pridané',
	'code-rev-modified-d' => 'zmazané',
	'code-rev-modified-m' => 'zmenené',
	'code-rev-status' => 'Stav:',
	'code-rev-status-set' => 'Zmeniť stav',
	'code-rev-tags' => 'Značky:',
	'code-rev-tag-add' => 'Pridať značku',
	'code-rev-comment-by' => 'Komentár od $1',
	'code-rev-comment-submit' => 'Poslať komentár',
	'code-rev-comment-preview' => 'Náhľad',
	'code-rev-diff' => 'Rozdiel',
	'code-rev-diff-link' => 'rozdiel',
	'code-status-new' => 'nový',
	'code-status-fixme' => 'fixme',
	'code-status-resolved' => 'vyriešené',
	'code-status-ok' => 'ok',
	'codereview-reply-link' => 'odpovedať',
	'repoadmin' => 'Správa úložiska',
	'repoadmin-new-legend' => 'Vytvoriť nové úložisko',
	'repoadmin-new-label' => 'Názov úložiska',
	'repoadmin-new-button' => 'Vytvoriť',
	'repoadmin-edit-legend' => 'Zmena úložiska „$1”',
	'repoadmin-edit-path' => 'Cesta k úložisku:',
	'repoadmin-edit-bug' => 'Cesta k Bugzille:',
	'repoadmin-edit-view' => 'Cesta k ViewVC:',
	'repoadmin-edit-button' => 'OK',
	'repoadmin-edit-sucess' => 'Úložisko „[[Special:Code/$1|$1]]” bolo úspešne zmenené.',
	'right-repoadmin' => 'Spravovať úložiská kódu',
	'right-codereview-add-tag' => 'Pridať revíziám nové značky',
	'right-codereview-remove-tag' => 'Odstrániť značky z revízií',
	'right-codereview-post-comment' => 'Pridať revíziám komentáre',
	'right-codereview-set-status' => 'Zmeniť stav revízií',
);

/** Swedish (Svenska)
 * @author Boivie
 * @author Najami
 */
$messages['sv'] = array(
	'code' => 'Kodgranskning',
	'code-comments' => 'Kommentarer',
	'code-desc' => '[[Special:Code|Kodgranskningsverktyg]] med [[Special:RepoAdmin|stöd för Subversion]]',
	'code-no-repo' => 'Ingen databas konfigurerad!',
	'code-author-haslink' => 'Denna författare är länkad till wiki-användaren $1',
	'code-author-dolink' => 'Länka denna författare till en wiki-användare :',
	'code-author-name' => 'Skriv in ett användarnamn:',
	'code-author-success' => 'Författaren $1 har med framgång länkats till wiki-användaren $2',
	'code-field-id' => 'Version',
	'code-field-author' => 'Författare',
	'code-field-message' => 'Kommentar',
	'code-field-status' => 'Status',
	'code-field-timestamp' => 'Datum',
	'code-field-comments' => 'Noter',
	'code-rev-author' => 'Författare:',
	'code-rev-message' => 'Kommentar:',
	'code-rev-repo' => 'Databas:',
	'code-rev-rev' => 'Version:',
	'code-rev-rev-viewvc' => 'på ViewVC',
	'code-rev-paths' => 'Ändrade sökvägar:',
	'code-rev-modified-a' => 'tillagd',
	'code-rev-modified-r' => 'ersatt',
	'code-rev-modified-d' => 'raderad',
	'code-rev-modified-m' => 'ändrad',
	'code-rev-status' => 'Status:',
	'code-rev-status-set' => 'Ändra status',
	'code-rev-tags' => 'Taggar:',
	'code-rev-tag-add' => 'Lägg till tagg',
	'code-rev-comment-by' => 'Kommentar av $1',
	'code-rev-comment-submit' => 'Skicka kommentar',
	'code-rev-comment-preview' => 'Förhandsgranska',
	'code-rev-diff' => 'Diff',
	'code-rev-diff-link' => 'diff',
	'code-status-new' => 'ny',
	'code-status-fixme' => 'fixa-mig',
	'code-status-resolved' => 'löst',
	'code-status-ok' => 'ok',
	'codereview-reply-link' => 'svara',
	'repoadmin' => 'Databasadministration',
	'repoadmin-new-legend' => 'Skapa en ny databas',
	'repoadmin-new-label' => 'Databasnamn:',
	'repoadmin-new-button' => 'Skapa',
	'repoadmin-edit-legend' => 'Ändring av databas "$1"',
	'repoadmin-edit-path' => 'Databas-sökväg:',
	'repoadmin-edit-bug' => 'Bugzilla sökväg:',
	'repoadmin-edit-view' => 'ViewVC sökväg:',
	'repoadmin-edit-button' => 'OK',
	'repoadmin-edit-sucess' => 'Databasen "[[Special:Code/$1|$1]]" har modifierats med framgång.',
	'right-repoadmin' => 'Hantera kod-databaser',
	'right-codereview-add-tag' => 'Lägga nya taggar till versioner',
	'right-codereview-remove-tag' => 'Ta bort taggar från versioner',
	'right-codereview-post-comment' => 'Lägga till kommentarer till versioner',
	'right-codereview-set-status' => 'Ändra versioners status',
);

/** Telugu (తెలుగు)
 * @author Veeven
 */
$messages['te'] = array(
	'code-comments' => 'వ్యాఖ్యలు',
	'code-field-message' => 'వ్యాఖ్య',
	'code-field-status' => 'స్థితి',
	'code-field-timestamp' => 'తేదీ',
	'code-rev-message' => 'వ్యాఖ్య:',
	'code-rev-status' => 'స్థితి:',
	'code-status-ok' => 'సరి',
	'repoadmin-edit-button' => 'సరే',
);

/** Vietnamese (Tiếng Việt)
 * @author Minh Nguyen
 * @author Vinhtantran
 */
$messages['vi'] = array(
	'code' => 'Duyệt mã',
	'code-comments' => 'Ghi chú',
	'code-desc' => '[[Special:Code|Công cụ duyệt mã]] [[Special:RepoAdmin|hỗ trợ Subversion]]',
	'code-no-repo' => 'Chưa thiết lập kho dữ liệu!',
	'code-field-id' => 'Phiên bản',
	'code-field-author' => 'Tác giả',
	'code-field-message' => 'Ghi chú',
	'code-field-status' => 'Trạng thái',
	'code-field-timestamp' => 'Lúc giờ',
	'code-rev-author' => 'Tác giả:',
	'code-rev-message' => 'Ghi chú:',
	'code-rev-repo' => 'Kho dữ liệu:',
	'code-rev-rev' => 'Phiên bản:',
	'code-rev-rev-viewvc' => 'trên ViewVC',
	'code-rev-paths' => 'Đường dẫn được sửa đổi:',
	'code-rev-modified-a' => 'thêm',
	'code-rev-modified-r' => 'thay',
	'code-rev-modified-d' => 'xóa',
	'code-rev-modified-m' => 'sửa',
	'code-rev-status' => 'Trạng thái:',
	'code-rev-status-set' => 'Thay đổi trạng thái',
	'code-rev-tags' => 'Các thẻ:',
	'code-rev-tag-add' => 'Thêm thẻ:',
	'code-rev-comment-by' => '$1 ghi chú',
	'code-rev-comment-submit' => 'Lưu ghi chú',
	'code-rev-comment-preview' => 'Xem trước',
	'code-rev-diff' => 'So sánh',
	'code-rev-diff-link' => 'so sánh',
	'code-status-new' => 'mới',
	'code-status-fixme' => 'cần sửa',
	'code-status-resolved' => 'giải quyết',
	'code-status-ok' => 'được',
	'codereview-reply-link' => 'trả lời',
	'repoadmin' => 'Quản lý kho dữ liệu',
	'repoadmin-new-legend' => 'Tạo kho dữ liệu',
	'repoadmin-new-label' => 'Tên kho dữ liệu:',
	'repoadmin-new-button' => 'Tạo',
	'repoadmin-edit-legend' => 'Sửa đổi kho dữ liệu “$1”',
	'repoadmin-edit-path' => 'Đường dẫn trong kho dữ liệu:',
	'repoadmin-edit-bug' => 'Đường dẫn trên Bugzilla:',
	'repoadmin-edit-view' => 'Đường dẫn trên ViewVC:',
	'repoadmin-edit-button' => 'Sửa đổi',
	'repoadmin-edit-sucess' => 'Kho dữ liệu “[[Special:Code/$1|$1]]” đã được sửa đổi thành công.',
	'right-repoadmin' => 'Quản lý các kho mã',
	'right-codereview-add-tag' => 'Thêm thẻ mới vào phiên bản',
	'right-codereview-remove-tag' => 'Dời thẻ khỏi phiên bản',
	'right-codereview-post-comment' => 'Ghi chú về phiên bản',
	'right-codereview-set-status' => 'Thay đổi trạng thái phiên bản',
);

