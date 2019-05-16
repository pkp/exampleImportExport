{**
 * plugins/importexport/exampleImportExport/templates/export.tpl
 *
 * Copyright (c) 2014-2019 Simon Fraser University
 * Copyright (c) 2003-2019 John Willinsky
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @brief UI to export publications
 *}
{include file="common/header.tpl" pageTitle="plugins.importexport.exampleImportExport.name"}

<table class="pkpTable">
  <thead>
    <tr>
      <th>{translate key="plugins.importexport.exampleImportExport.id"}</th>
      <th>{translate key="plugins.importexport.exampleImportExport.title"}</th>
    </tr>
  </thead>
  <tbody>
    {foreach $publications as $publication}
      <tr>
        <td>{$publication->getId()}</td>
        <td>{$publication->getLocalizedTitle()}</td>
      </tr>
    {/foreach}
  </tbody>
</table>

<form method="POST" action="{plugin_url path="exportAll"}">
  <button class="pkp_button" type="submit">{translate key="plugins.importexport.exampleImportExport.exportAll"}</button>
</form>

{include file="common/footer.tpl"}
