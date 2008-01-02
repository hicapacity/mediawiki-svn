<?php
/** Portuguese (Português)
 * @author 555
 * @author Malafaya
 */
$messages = array(
	'editor'                      => 'Editor',
	'group-editor'                => 'Editores',
	'group-editor-member'         => 'Editor',
	'grouppage-editor'            => '{{ns:project}}:{{int:group-editor}}',
	'reviewer'                    => 'Crítico',
	'group-reviewer'              => 'Críticos',
	'group-reviewer-member'       => 'Crítico',
	'grouppage-reviewer'          => '{{ns:project}}:{{int:group-reviewer}}',
	'revreview-current'           => 'Rascunho',
	'tooltip-ca-current'          => 'Ver o rascunho atual desta página',
	'revreview-edit'              => 'Editar rascunho',
	'revreview-source'            => 'código do rascunho',
	'revreview-stable'            => 'Estável',
	'tooltip-ca-stable'           => 'Ver a edição estável desta página',
	'revreview-oldrating'         => 'Esteve avaliada como:',
	'revreview-noflagged'         => "Esta página não possui edições analisadas. Talvez ainda '''não''' tenha sido [[{{MediaWiki:Validationpage}}|verificada]] a sua qualidade.",
	'stabilization-tab'           => '(gq)',
	'tooltip-ca-default'          => 'Configurações da Garantia de Qualidade',
	'validationpage'              => '{{ns:help}}:Validação de páginas',
	'revreview-quick-none'        => "'''Atual'''. (sem edições analisadas)",
	'revreview-quick-see-quality' => "'''Rascunho'''. [[{{fullurl:{{FULLPAGENAMEE}}|stable=1}} ver edição estável]] ($2 [{{fullurl:{{FULLPAGENAMEE}}|oldid=$1&diff=cur&editreview=1}} {{plural:$2|alteração|alterações}}])",
	'revreview-quick-see-basic'   => "'''Rascunho'''. [[{{fullurl:{{FULLPAGENAMEE}}|stable=1}} ver edição estável]] ($2 [{{fullurl:{{FULLPAGENAMEE}}|oldid=$1&diff=cur&editreview=1}} {{plural:$2|alteração|alterações}}])",
	'revreview-quick-basic'       => "'''[[{{MediaWiki:Validationpage}}|Analisada]]'''. [[{{fullurl:{{FULLPAGENAMEE}}|stable=0}} ver rascunho]] ($2 [{{fullurl:{{FULLPAGENAMEE}}|oldid=$1&diff=cur&editreview=1}} {{plural:$2|alteração|alterações}}])",
	'revreview-quick-quality'     => "'''[[{{MediaWiki:Validationpage}}|Estável]]'''. [[{{fullurl:{{FULLPAGENAMEE}}|stable=0}} ver rascunho]] ($2 [{{fullurl:{{FULLPAGENAMEE}}|oldid=$1&diff=cur&editreview=1}} {{plural:$2|alteração|alterações}}])",
	'revreview-newest-basic'      => 'A [{{fullurl:{{FULLPAGENAMEE}}|stable=1}} mais recente edição analisada] ([{{fullurl:Special:Stableversions|page={{FULLPAGENAMEE}}}} listar todas]) foi [{{fullurl:Special:Log|type=review&page={{FULLPAGENAMEE}}}} aprovada]
	 em <i>$2</i>. [{{fullurl:{{FULLPAGENAMEE}}|oldid=$1&diff=cur&editreview=1}} $3 {{plural:$3|alteração|alterações}}] {{plural:$3|necessita|necessitam}} revisão.',
	'revreview-newest-quality'    => 'A [{{fullurl:{{FULLPAGENAMEE}}|stable=1}} mais recente edição com qualidade] ([{{fullurl:Special:Stableversions|page={{FULLPAGENAMEE}}}} listar todas]) foi [{{fullurl:Special:Log|type=review&page={{FULLPAGENAMEE}}}} aprovada] em <i>$2</i>. [{{fullurl:{{FULLPAGENAMEE}}|oldid=$1&diff=cur&editreview=1}} $3 {{plural:$3|alteração|alterações}}] {{plural:$3|necessita|necessitam}} análise.',
	'revreview-basic'             => 'Esta é a mais recente edição [[{{MediaWiki:Validationpage}}|analisada]], [{{fullurl:Special:Log|type=review&page={{FULLPAGENAMEE}}}} aprovada] em <i>$2</i>. O [{{fullurl:{{FULLPAGENAMEE}}|stable=0}} rascunho] pode ser [{{fullurl:{{FULLPAGENAMEE}}|action=edit}} editado]; [{{fullurl:{{FULLPAGENAMEE}}|oldid=$1&diff=cur&editreview=1}} $3 {{plural:$3|alteração aguarda|alterações aguardam}}] revisão.',
	'revreview-quality'           => 'Esta é a mais recente edição [[{{MediaWiki:Validationpage}}|estável]], [{{fullurl:Special:Log|type=review&page={{FULLPAGENAMEE}}}} aprovada] em <i>$2</i>. O [{{fullurl:{{FULLPAGENAMEE}}|stable=0}} rascunho] pode ser [{{fullurl:{{FULLPAGENAMEE}}|action=edit}} editado]; [{{fullurl:{{FULLPAGENAMEE}}|oldid=$1&diff=cur&editreview=1}} $3 {{plural:$3|alteração aguarda|alterações aguardam}}] revisão.',
	'revreview-static'            => "Esta é uma edição [[{{MediaWiki:Validationpage}}|revista]] de '''[[:$3|$3]]''', [{{fullurl:Special:Log/review|page=$1}} aprovada] em <i>$2</i>.",
	'revreview-toggle'            => '(+/-)',
	'revreview-note'              => '[[{{ns:user}}:$1|$1]] deixou as seguintes observações ao [[{{MediaWiki:Validationpage}}|analisar]] esta edição:',
	'revreview-update'            => 'Por gentileza, analise todas as alterações exibidas a seguir, feitas desde a última edição estável desta página. Talvez as predefinições e imagens utilizadas possam ter sido também alteradas.',
	'revreview-update-none'       => 'Por gentileza, reveja todas as alterações (exibidas a seguir) feitas desde a edição estável.',
	'revreview-auto'              => '(automático)',
	'revreview-auto-w'            => "Você está editando a edição estável. Todas as alterações serão '''automaticamente tidas como revistas'''. Talvez deseje prever a página antes de a salvar.",
	'revreview-auto-w-old'        => "Você está editando uma edição antiga. Todas as alterações serão '''automaticamente tidas como revistas'''. Talvez deseje prever a página antes de a salvar.",
	'revreview-patrolled'         => 'A edição selecionada de [[:$1|$1]] foi marcada como patrulhada.',
	'hist-stable'                 => '[analisada]',
	'hist-quality'                => '[estável]',
	'flaggedrevs'                 => 'Edições Analisadas',
	'review-logpage'              => 'Registo de análise de edições',
	'review-logpagetext'          => 'Este é um registo de alterações nas [[{{MediaWiki:Validationpage}}|análises]] de páginas de conteúdo.',
	'review-logentry-app'         => 'analisou [[$1]]',
	'review-logentry-dis'         => 'rebaixou uma edição de [[$1]]',
	'review-logaction'            => 'ID de edição: $1',
	'stable-logpage'              => 'Registo de edições estáveis',
	'stable-logpagetext'          => 'Este é um registo de modificações nas configurações das [[{{MediaWiki:Validationpage}}|edições estáveis]] das páginas de conteúdo.',
	'stable-logentry'             => 'a versão estável de [[$1]] foi configurada',
	'stable-logentry2'            => 'zerar a forma de definir versões estáveis de [[$1]]',
	'revisionreview'              => 'Analisar edições',
	'revreview-main'              => 'Você precisa seleccionar uma edição específica de uma página de conteúdo para poder analisá-la.

Veja [[{{ns:special}}:Unreviewedpages]] para uma listagem de páginas ainda não revistas.',
	'revreview-selected'          => "Edição selecionada de '''$1:'''",
	'revreview-text'              => 'As edições aprovadas são exibidas por padrão no lugar de edições mais recentes.',
	'revreview-toolow'            => 'Você precisará atribuir em cada um dos atributos valores mais altos do que "rejeitada" para que uma edição seja considerada aprovada. Para rebaixar uma edição, defina todos os atributos como "rejeitada".',
	'revreview-flag'              => 'Analise esta edição (#$1)',
	'revreview-legend'            => 'Avaliar conteúdo da edição',
	'revreview-notes'             => 'Observações ou notas a serem exibidas:',
	'revreview-accuracy'          => 'Precisão',
	'revreview-accuracy-0'        => 'Rejeitada',
	'revreview-accuracy-1'        => 'Objetiva',
	'revreview-accuracy-2'        => 'Precisa',
	'revreview-accuracy-3'        => 'Bem referenciada',
	'revreview-accuracy-4'        => 'Exemplar',
	'revreview-depth'             => 'Profundidade',
	'revreview-depth-0'           => 'Rejeitada',
	'revreview-depth-1'           => 'Básica',
	'revreview-depth-2'           => 'Moderada',
	'revreview-depth-3'           => 'Alta',
	'revreview-depth-4'           => 'Exemplar',
	'revreview-style'             => 'Inteligibilidade',
	'revreview-style-0'           => 'Rejeitada',
	'revreview-style-1'           => 'Aceitável',
	'revreview-style-2'           => 'Boa',
	'revreview-style-3'           => 'Concisa',
	'revreview-style-4'           => 'Exemplar',
	'revreview-log'               => 'Comentário:',
	'revreview-submit'            => 'Enviar crítica',
	'revreview-changed'           => "'''A acção seleccionada não pode ser executada nesta edição.'''
	
Uma predefinição ou imagem pode ter sido requisitada sem uma edição específica ter sido informada. Isso pode ocorrer quando uma predefinição dinâmica faz transclusão de outra imagem ou predefinição através de uma variável que pode ter sido alterada enquanto era feita a edição crítica nesta página. Recarregar a página e enviar uma nova edição crítica talvez seja suficiente para contornar este contratempo.",
	'stableversions'              => 'Edições Estáveis',
	'stableversions-leg1'         => 'Listar as edições revistas de uma página',
	'stableversions-page'         => 'Título da página',
	'stableversions-none'         => '[[:$1]] não possui edições analisadas.',
	'stableversions-list'         => 'A seguir, uma lista das edições de "[[:$1]]" que foram analisadas:',
	'stableversions-review'       => 'Analisada às <i>$1</i> por $2',
	'review-diff2stable'          => 'Comparar com a edição estável',
	'unreviewedpages'             => 'Páginas não revistas',
	'viewunreviewed'              => 'Listar páginas de conteúdo que ainda não tenham sido revistas',
	'unreviewed-outdated'         => 'Exibir páginas que possuam edições posteriores à considerada como estável que ainda não tenham sido avaliadas.',
	'unreviewed-category'         => 'Categoria',
	'unreviewed-diff'             => 'Alterações',
	'unreviewed-list'             => 'Esta página lista as páginas de conteúdo que ainda não foram revistas ou que possuam uma nova edição a ser analisada.',
	'revreview-visibility'        => 'Esta página possui uma [[{{MediaWiki:Validationpage}}|edição estável]], a qual pode ser  [{{fullurl:Special:Stabilization|page={{FULLPAGENAMEE}}}} configurada].',
	'stabilization'               => 'Configurações da Garantia de Qualidade',
	'stabilization-text'          => 'Altere a seguir as configurações de como a versão estável de [[:$1|$1]] é selecionada e exibida.',
	'stabilization-perm'          => 'Sua conta não possui permissão para alterar as configurações de edições estáveis.
Seguem-se as configurações para [[:$1|$1]]:',
	'stabilization-page'          => 'Nome da página:',
	'stabilization-leg'           => 'Configurar a edição estável de uma página',
	'stabilization-select'        => 'Como é selecionada a edição estável',
	'stabilization-select1'       => 'A última edição analisada como de qualidade; se inexistente, a mais recentemente analisada',
	'stabilization-select2'       => 'A mais recentemente analisada',
	'stabilization-def'           => 'Edição exibida na visualização padrão de página',
	'stabilization-def1'          => 'A edição estável; se inexistente, exibir a edição actual',
	'stabilization-def2'          => 'A edição actual',
	'stabilization-submit'        => 'Confirmar',
	'stabilization-notexists'     => 'A página "[[:$1|$1]]" não existe. Não é possível alterar a configuração.',
	'stabilization-notcontent'    => 'A página "[[:$1|$1]]" não pode ser analisada. Não é possível configurá-la.',
	'stabilization-comment'       => 'Comentário:',
	'stabilization-sel-short'     => 'Precedência',
	'stabilization-sel-short-0'   => 'Qualidade',
	'stabilization-sel-short-1'   => 'Nenhum',
	'stabilization-def-short'     => 'Padrão',
	'stabilization-def-short-0'   => 'Atual',
	'stabilization-def-short-1'   => 'Estável',
	'reviewedpages'               => 'Páginas revistas',
	'reviewedpages-leg'           => 'Listar páginas que tenham sido analisadas em um nível específico',
	'reviewedpages-list'          => 'As páginas a seguir foram analisadas no nível especificado',
	'reviewedpages-none'          => 'Não há páginas nesta lista',
	'reviewedpages-lev-0'         => 'Objetiva',
	'reviewedpages-lev-1'         => 'Qualidade',
	'reviewedpages-lev-2'         => 'Exemplar',
	'reviewedpages-all'           => 'edições analisadas',
	'reviewedpages-best'          => 'a mais recente edição de classificação mais alta',
);
