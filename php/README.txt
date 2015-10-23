Passo a passo de como configurar e integrar sua plataforma com API de Embed da Replay4me
Para exibir o conteúdo das páginas, foi utilizado Boostrap 3.3.4

1 - Abra o arquivo configs.php
2 - Altere as informações de CLIENT_ID e CLIENT_SECRET referente à sua empresa
3 - Abra o arquivo index.php
4 - Informe o email e nome do usuário ($email,$name) que terão acesso ao conteúdo. Essa informação deverá ser dinâmica e integrada com sua plataforma.
5 - Personalize as informações do embed com as opções "target", "share_notes", "auto_play" e "title"
    target = local no código html onde deverá exibir o embed
    share_notes = exibir botão de compartilhar informações
    auto_play = permite que o vídeo inicie automaticamente 
    title = exibir o título do embed

6 - Execute o arquivo index.php.
6.1 - No menu superior, serão listados os módulos disponíveis. Selecione um módulo
6.2 - Serão listados os conteúdos disponíveis (playlists e trilhas). Selecione um conteúdo
6.3 - Será listado o conteúdo selecionado

7. - Relatórios
7.1 - reports.php = exibe relatório de todos os usuários pertencentes a playlist ou trilha do módulo selecionad
7.2 - report_user.php = exibe relatório de todas as playlist ou trilhas por usuário expecífico de um módulo
