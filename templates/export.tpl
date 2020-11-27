{**
 * templates/export.tpl
 *
 * Copyright (c) 2014-2020 Simon Fraser University
 * Copyright (c) 2003-2020 John Willinsky
 * Distributed under the GNU GPL v3. For full terms see the file LICENSE.
 *
 * @brief UI to export publications
 *}
{extends file="layouts/backend.tpl"}

{block name="page"}
	<h1 class="app__pageHeading">
		{$pageTitle}
	</h1>

	<div class="app__contentPanel">
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
	</div>
{/block}
