<?php

/**
 * The MetaModels extension allows the creation of multiple collections of custom items,
 * each with its own unique set of selectable attributes, with attribute extendability.
 * The Front-End modules allow you to build powerful listing and filtering of the
 * data in each collection.
 *
 * PHP version 5
 * @package     MetaModels
 * @subpackage  AttributeCombinedValues
 * @author      Christian Schiffler <c.schiffler@cyberspectrum.de>
 * @author      Stefan Heimes <cms@men-at-work.de>
 * @copyright   The MetaModels team.
 * @license     LGPL.
 * @filesource
 */

/**
 * This is the MetaModelAttribute class for handling combined values.
 *
 * @package    MetaModels
 * @subpackage AttributeCombinedValues
 * @author     Christian Schiffler <c.schiffler@cyberspectrum.de>
 * @author     Stefan Heimes <cms@men-at-work.de>
 */
class MetaModelAttributeCombinedValues extends MetaModelAttributeSimple
{

	public function getSQLDataType()
	{
		return 'varchar(255) NOT NULL default \'\'';
	}

	public function getAttributeSettingNames()
	{
		return array_merge(parent::getAttributeSettingNames(), array(
			'combinedvalues_fields',
			'combinedvalues_format',
			'force_combinedvalues',
			'isunique',
			'mandatory',
			'filterable',
			'searchable',
			'sortable'
		));
	}

	public function getFieldDefinition($arrOverrides = array())
	{
		$arrFieldDef = parent::getFieldDefinition($arrOverrides);

		$arrFieldDef['inputType'] = 'text';

		// we do not need to set mandatory, as we will automatically update our value when isunique is given.
		if ($this->get('isunique'))
		{
			$arrFieldDef['eval']['mandatory'] = false;
		}
		return $arrFieldDef;
	}

	/**
	 * {@inheritdoc}
	 */
	public function modelSaved($objItem)
	{
		// combined values already defined and no update forced, get out!
		if ($objItem->get($this->getColName()) && (!$this->get('force_combinedvalues')))
		{
			return;
		}

		$arrCombinedValues = '';
		foreach (deserialize($this->get('combinedvalues_fields')) as $strAttribute)
		{
			if ($this->isMetaField($strAttribute['field_attribute']))
			{
				$strField            = $strAttribute['field_attribute'];
				$arrCombinedValues[] = $objItem->get($strField);
			}
			else
			{
				$arrValues           = $objItem->parseAttribute($strAttribute['field_attribute'], 'text', null);
				$arrCombinedValues[] = $arrValues['text'];
			}
		}

		$strCombinedValues = vsprintf($this->get('combinedvalues_format'), $arrCombinedValues);
		$strCombinedValues = trim($strCombinedValues);

		// we need to fetch the attribute values for all attribs in the combinedvalues_fields and update the database and the model accordingly.
		if ($this->get('isunique') && $this->searchFor($strCombinedValues))
		{
			$intCount = 1;
			// ensure uniqueness.
			while (count($this->searchFor($strCombinedValues . ' (' . (++$intCount) . ')')) > 0){}
			$strCombinedValues = $strCombinedValues . ' (' . $intCount . ')';
		}

		$this->setDataFor(array($objItem->get('id') => $strCombinedValues));
		$objItem->set($this->getColName(), $strCombinedValues);
	}

	/**
	 * Check if we have a metafield from metatmodels.
	 * 
	 * @param string $strField The selected value.
	 * 
	 * @return boolean True => Yes we have | False => nope.
	 */
	protected function isMetaField($strField)
	{
		$strField = trim($strField);

		if (in_array($strField, $GLOBALS['METAMODELS_SYSTEM_COLUMNS']))
		{
			return true;
		}

		return false;
	}

}