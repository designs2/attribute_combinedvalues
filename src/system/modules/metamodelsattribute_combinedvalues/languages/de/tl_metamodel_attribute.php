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
 * Fields
 */
$GLOBALS['TL_LANG']['tl_metamodel_attribute']['typeOptions']['combinedvalues'] = 'Kombinierte Werte';
$GLOBALS['TL_LANG']['tl_metamodel_attribute']['combinedvalues_fields']         = array('Felder', 'Bitte wählen Sie ein oder mehrere Felder aus, aus denen der Text erstellt werden soll.');
$GLOBALS['TL_LANG']['tl_metamodel_attribute']['combinedvalues_format']         = array('Formate', 'Verwenden Sie "%s" oder einen beliebigen anderen Format Platzhalter wie unter [<a href="http://php.net/sprintf" onclick="window.open(this.href)">sprintf</a>] beschrieben, um das Format vorzugeben.');
$GLOBALS['TL_LANG']['tl_metamodel_attribute']['force_combinedvalues']          = array('Neuerstellung erzwingen', 'Erzwingt die Neuerstellung, wenn sich eines der abhängigen Felder ändert.');
$GLOBALS['TL_LANG']['tl_metamodel_attribute']['field_attribute']               = 'Attribute';