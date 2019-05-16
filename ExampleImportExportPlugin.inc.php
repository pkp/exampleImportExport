<?php
/**
 * @file plugins/importexport/exampleImportExport/ExampleImportExportPlugin.inc.php
 *
 * Copyright (c) 2014-2019 Simon Fraser University
 * Copyright (c) 2003-2019 John Willinsky
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @class ExampleImportExportPlugin
 * @ingroup plugins_importexport_exampleimportexport
 *
 * @brief An example plugin demonstrating how to write an import/export plugin.
 */
import('lib.pkp.classes.plugins.ImportExportPlugin');
class ExampleImportExportPlugin extends ImportExportPlugin {
	/**
	 * @copydoc ImportExportPlugin::register()
	 */
	public function register($category, $path, $mainContextId = NULL) {
    $success = parent::register($category, $path);
		$this->addLocaleData();
		return $success;
	}

	/**
	 * @copydoc ImportExportPlugin::getName()
	 */
	public function getName() {
		return 'ExampleImportExportPlugin';
	}

	/**
	 * @copydoc ImportExportPlugin::getDisplayName()
	 */
	public function getDisplayName() {
		return __('plugins.importexport.exampleImportExport.name');
	}

	/**
	 * @copydoc ImportExportPlugin::getDescription()
	 */
	public function getDescription() {
		return __('plugins.importexport.exampleImportExport.description');
	}

	/**
	 * @copydoc ImportExportPlugin::register()
	 */
	public function display($args, $request) {
		parent::display($args, $request);

		// Get the journal or press id
		$contextId = Application::get()->getRequest()->getContext()->getId();

		// Use the path to determine which action
		// should be taken.
		$path = array_shift($args);
		switch ($path) {

			// Stream a CSV file for download
			case 'exportAll':
				header('content-type: text/comma-separated-values');
				header('content-disposition: attachment; filename=articles-' . date('Ymd') . '.csv');
				$publications = $this->getAll($contextId);
				$this->export($publications, 'php://output');
				break;

			// When no path is requested, display a list of publications
			// to export and a button to run the `exportAll` path.
			default:
				$templateMgr = TemplateManager::getManager($request);
				$templateMgr->assign('publications', $this->getAll($contextId));
				$templateMgr->display($this->getTemplateResource('export.tpl'));
		}
	}

	/**
	 * @copydoc ImportExportPlugin::executeCLI()
	 */
	public function executeCLI($scriptName, &$args) {
		$csvFile = array_shift($args);
		$contextId = array_shift($args);

		if (!$csvFile || !$contextId) {
			$this->usage('');
		}

		$publications = $this->getAll($contextId);
		$this->export($publications, $csvFile);
	}

	/**
	 * @copydoc ImportExportPlugin::usage()
	 */
	public function usage($scriptName) {
		echo __('plugins.importexport.exampleImportExport.cliUsage', array(
			'scriptName' => $scriptName,
			'pluginName' => $this->getName()
		)) . "\n";
	}

	/**
	 * A helper method to get all publications for export
	 *
	 * @param	int	$contextId Which journal or press to get submissions for
	 * @return array
	 */
	public function getAll($contextId) {
		import('lib.pkp.classes.submission.Submission');
		return Services::get('submission')->getMany([
			'contextId' => $contextId,
			'status' => STATUS_PUBLISHED,
		]);
	}

	/**
	 * A helper method to stream all publications to a CSV file
	 */
	public function export($publications, $filename) {
		$fp = fopen($filename, 'wt');
    fputcsv($fp, ['ID', 'Title']);
    foreach ($publications as $publication) {
      fputcsv($fp, [$publication->getId(), $publication->getLocalizedTitle()]);
    }
		fclose($fp);
	}
}