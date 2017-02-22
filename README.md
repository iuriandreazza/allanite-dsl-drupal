# allanite-dsl-drupal



Examples
--

To create an page node

    drush -v ccm:add AddPageSports type=Page name=SportsPageName title=SportsPage 
    
Node Type Optional Custom params
    
    menu:enabled=true|false
    menu:link_title=MenuPageSports
    menu:description=Desc Menu Page Sports
    menu:parent=main-menu-0
    menu:weight=5
    path=sport alias
    comment=1
    status=0|1
    promote=0
    revision=0
    body:sumary=sumary
    body:value=value
    body:format=filtered_html|field_page_body|full_html 
    language=en
    uid=0123



DELETE FROM system WHERE name = 'ccm' AND type = 'module'
