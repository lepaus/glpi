<?php
/*
 * @version $Id$
 -------------------------------------------------------------------------
 GLPI - Gestionnaire Libre de Parc Informatique
 Copyright (C) 2003-2010 by the INDEPNET Development Team.

 http://indepnet.net/   http://glpi-project.org
 -------------------------------------------------------------------------

 LICENSE

 This file is part of GLPI.

 GLPI is free software; you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation; either version 2 of the License, or
 (at your option) any later version.

 GLPI is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.

 You should have received a copy of the GNU General Public License
 along with GLPI; if not, write to the Free Software
 Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 --------------------------------------------------------------------------
 */

// ----------------------------------------------------------------------
// Original Author of file:
// Purpose of file:
// ----------------------------------------------------------------------


checkCentralAccess();

if (!($task instanceof CommonITILTask)) {
   displayErrorAndDie('');
}
if (!$task->canView()) {
   displayRightError();
}

$itemtype = $task->getItilObjectItemType();
$fk = getForeignKeyFieldForItemType($itemtype);

if (isset($_POST["add"])) {
   $task->check(-1,'w',$_POST);
   $task->add($_POST);

   Event::log($task->getField($fk), strtolower($itemtype), 4, "tracking",
              $_SESSION["glpiname"]."  ".$LANG['log'][21]);
   glpi_header(getItemTypeFormURL($itemtype)."?id=".$task->getField($fk));

} else if (isset($_POST["delete"])) {
   $task->check($_POST['id'], 'd');
   $task->delete($_POST);

   Event::log($task->getField($fk), strtolower($itemtype), 4, "tracking",
              $_SESSION["glpiname"]." ".$LANG['log'][21]);
   glpi_header(getItemTypeFormURL($itemtype)."?id=".$task->getField($fk));

} else if (isset($_POST["update"])) {
   $task->check($_POST["id"],'w');
   $task->update($_POST);

   Event::log($task->getField($fk), strtolower($itemtype), 4, "tracking",
              $_SESSION["glpiname"]." ".$LANG['log'][21]);
   glpi_header($_SERVER['HTTP_REFERER']);

}

displayErrorAndDie('Lost');

?>
