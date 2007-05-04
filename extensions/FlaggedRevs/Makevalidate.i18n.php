<?php
/**
 * Internationalisation file for makevalidate extension.
 *
 * @package MediaWiki
 * @subpackage Extensions
*/

function efMakeValidateMessages() {
	$messages = array();
	
/* English (Aaron Schulz) */
$messages['en'] = array(
	'makevalidate'       => 'Promote/demote editors',
	'makevalidate-header'   => '<strong>This form is used by sysops and bureaucrats to promote users to article 
	validators.</strong><br> Type the name of the user in the box and press the button to set the user\'s rights. 
	Granting users reviewer status will automatically grant them editor status. Revoking editor status will
	automatically revoke reviewer status.',
	'makevalidate-username'  => 'Name of the user:',
	'makevalidate-search' => 'Go',
	'makevalidate-iseditor' => '[[User:$1|$1]] has editor status.',
	'makevalidate-noteditor' => '[[User:$1|$1]] does not have editor status.',
	'makevalidate-isvalidator' => '[[User:$1|$1]] has reviewer status.',
	'makevalidate-notvalidator' => '[[User:$1|$1]] does not have reviewer status.',
	'makevalidate-legend' => 'Change user rights:',
	'makevalidate-change-e' => 'Editor status:',
	'makevalidate-change-r' => 'Reviewer status:',
	'makevalidate-grant1' => 'Grant',
	'makevalidate-revoke1' => 'Revoke',
	'makevalidate-grant2' => 'Grant',
	'makevalidate-revoke2' => 'Revoke',
	'makevalidate-comment' => 'Comment:',
	'makevalidate-granted-e' => '[[User:$1|$1]] now has editor status.',
	'makevalidate-revoked-e' => '[[User:$1|$1]] no longer has editor status.',
	'makevalidate-granted-r' => '[[User:$1|$1]] now has reviewer status.',
	'makevalidate-revoked-r' => '[[User:$1|$1]] no longer has reviewer status.',
	'makevalidate-logpage' => 'Editor status log',
	'makevalidate-logpagetext' => 'This is a log of changes to users\' [[Help:Article validation|article validation]] status.',
	'makevalidate-logentrygrant-e' => 'granted editor status to [[$1]]',
	'makevalidate-logentryrevoke-e' => 'removed editor status from [[$1]]',
	'makevalidate-logentrygrant-r' => 'granted reviewer status to [[$1]]',
	'makevalidate-logentryrevoke-r' => 'removed reviewer status from [[$1]]',
	'makevalidate-autosum' => 'autopromoted',
);
/* German (Raimond Spekking) */
$messages['de'] = array(
	'makevalidate'       => 'Editor-Recht erteilen/entziehen',
	'makevalidate-header'   => '<strong>Mit diesem Formular können Administratoren und Bürokraten Benutzern das Recht zur Artikelprüfung erteilen.</strong><br />
	Geben Sie den Benutzernamen in das Feld ein und drücken Sie auf den Button um das Recht zu setzen.
	Durch Erteilung des Prüfrechts wird automatisch auch das Editor-Recht erteilt. Der Entzug des Editors-Rechts hat automatisch den Entzug des Prüfrechts zur Folge.',
	'makevalidate-username'  => 'Benutzername:',
	'makevalidate-search' => 'Ausführen',
	'makevalidate-iseditor' => '[[User:$1|$1]] hat das Editor-Recht.',
	'makevalidate-noteditor' => '[[User:$1|$1]] hat kein Editor-Recht.',
	'makevalidate-isvalidator' => '[[User:$1|$1]] hat das Prüfrecht.',
	'makevalidate-notvalidator' => '[[User:$1|$1]] hat kein Prüfrecht.',
	'makevalidate-legend' => 'Benutzerrechte ändern:',
	'makevalidate-change-e' => 'Editor-Recht:',
	'makevalidate-change-r' => 'Prüfrecht:',
	'makevalidate-grant1' => 'Erteile',
	'makevalidate-revoke1' => 'Entziehe',
	'makevalidate-grant2' => 'Erteile',
	'makevalidate-revoke2' => 'Entziehe',
	'makevalidate-comment' => 'Kommentar:',
	'makevalidate-granted-e' => '[[User:$1|$1]] hat nun das Editor-Recht.',
	'makevalidate-revoked-e' => '[[User:$1|$1]] wurde das Editor-Recht entzogen.',
	'makevalidate-granted-r' => '[[User:$1|$1]] hat nun das Prüfrecht.',
	'makevalidate-revoked-r' => '[[User:$1|$1]] wurde das Prüfrecht entzogen.',
	'makevalidate-logpage' => 'Editor-Rechte-Logbuch',
	'makevalidate-logpagetext' => 'Dies ist das Änderungs-Logbuch der Benutzer-[[Help:Article validation|Prüfrechte]].',
	'makevalidate-logentrygrant-e' => 'erteilte das Editor-Recht an [[$1]]',
	'makevalidate-logentryrevoke-e' => 'entzog das Editor-Recht von [[$1]]',
	'makevalidate-logentrygrant-r' => 'erteilte das Prüfrecht an [[$1]]',
	'makevalidate-logentryrevoke-r' => 'entzog das Prüfrecht von [[$1]]',
	'makevalidate-autosum' => 'automatische Rechtevergabe',
);
/* Portuguese (Lugusto) */
$messages['pt'] = array(
	'makevalidate'       => 'Promover/rebaixar editores',
	'makevalidate-header'   => '<strong>Este é um formulário utilizado por {{int:group-sysop}} e {{int:group-bureaucrat}} para promover usuários a validadores de páginas.</strong><br>Digite o nome de usuário no espaço indicado e clique no botão correspondente a alteração de privilégios desejada de ser feita. Conceder o estado de {{int:group-reviewer-member}} fará com que a pessoa se torne {{int:group-editor-member}} automaticamente. Revogar o status de {{int:group-editor-member}} automaticamente revogará também o estado de {{int:group-reviewer-member}}.',
	'makevalidate-username'  => 'Nome de usuário:',
	'makevalidate-search' => 'Ir',
	'makevalidate-iseditor' => '[[{{ns:user}}:$1|$1]] possui status de {{int:group-editor-member}}.',
	'makevalidate-noteditor' => '[[{{ns:user}}:$1|$1]] não possui status de {{int:group-editor-member}}.',
	'makevalidate-isvalidator' => '[[{{ns:user}}:$1|$1]] possui status de {{int:group-reviewer-member}}.',
	'makevalidate-notvalidator' => '[[{{ns:user}}:$1|$1]] não possui status de {{int:group-reviewer-member}}.',
	'makevalidate-legend' => 'Alterar direitos de usuário:',
	'makevalidate-change-e' => 'Status de {{int:group-editor-member}}:',
	'makevalidate-change-r' => 'Status de {{int:group-reviewer-member}}:',
	'makevalidate-grant1' => 'Conceder',
	'makevalidate-revoke1' => 'Revocar',
	'makevalidate-grant2' => 'Conceder',
	'makevalidate-revoke2' => 'Revocar',
	'makevalidate-comment' => 'Comentário:',
	'makevalidate-granted-e' => '[[{{ns:user}}:$1|$1]] agora possui status de {{int:group-editor-member}}.',
	'makevalidate-revoked-e' => '[[{{ns:user}}:$1|$1]] não mais possui status de {{int:group-editor-member}}.',
	'makevalidate-granted-r' => '[[{{ns:user}}:$1|$1]] agora possui status de {{int:group-reviewer-member}}.',
	'makevalidate-revoked-r' => '[[{{ns:user}}:$1|$1]] não mais possui status de {{int:group-reviewer-member}}.',
	'makevalidate-logpage' => 'Registo de status de editores',
	'makevalidate-logpagetext' => 'Este é um registo de alterações de status de [[{{ns:help}}:Validação de páginas|validadores de páginas]] ([[{{int:grouppage-editor}}|{{int:group-editor}}]] e [[{{int:grouppage-reviewer}}|{{int:group-reviewer}}]]).',
	'makevalidate-logentrygrant-e' => 'concedido status de {{int:group-editor-member}} para [[$1]]',
	'makevalidate-logentryrevoke-e' => 'removido status de {{int:group-editor-member}} de [[$1]]',
	'makevalidate-logentrygrant-r' => 'concedido status de {{int:group-reviewer-member}} para [[$1]]',
	'makevalidate-logentryrevoke-r' => 'removido status de {{int:group-reviewer-member}} para [[$1]]',
	'makevalidate-autosum' => 'promovido automaticamente',
);

return $messages;
}
?>
