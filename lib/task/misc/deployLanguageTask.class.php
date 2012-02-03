<?php

/*************************************************************************************
* ===================================================================================*
* Software by: Danyuki Software Limited                                              *
* This file is part of Plancake.                                                     *
*                                                                                    *
* Copyright 2009-2010-2011-2012 by:     Danyuki Software Limited                          *
* Support, News, Updates at:  http://www.plancake.com                                *
* Licensed under the AGPL version 3 license.                                         *                                                       *
* Danyuki Software Limited is registered in England and Wales (Company No. 07554549) *
**************************************************************************************
* Plancake is distributed in the hope that it will be useful,                        *
* but WITHOUT ANY WARRANTY; without even the implied warranty of                     *
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the                      *
* GNU Affero General Public License for more details.                                *
*                                                                                    *
* You should have received a copy of the GNU Affero General Public License           *
* along with this program.  If not, see <http://www.gnu.org/licenses/>.              *
*                                                                                    *
**************************************************************************************/

/**
 * Packs a new release to make it ready to be downloaded by users
 *
 * @package    symfony
 * @subpackage task
 * @version    SVN: $Id: sfProjectDeployTask.class.php 10956 2008-08-19 15:20:48Z fabien $
 */
class deployLanguageTask extends sfBaseTask
{
  /**
   * @see sfTask
   */
  protected function configure()
  {
    $this->aliases = array('deploy-language');
    $this->namespace = 'misc';
    $this->name = 'deploy-language';
    $this->briefDescription = 'Deploy a language.';

    $this->addArguments(array(
      new sfCommandArgument('lang_to_deploy', sfCommandArgument::REQUIRED, "The development language you want to deploy."),
    ));

    $this->addArguments(array(
      new sfCommandArgument('live_lang', sfCommandArgument::REQUIRED, "The live language you want to copy over"),
    ));


    $this->detailedDescription = <<<EOF
Deploy a language.
EOF;

  }

  /**
   * @see sfTask
   */
  protected function execute($arguments = array(), $options = array())
  {
    require_once(dirname(__FILE__).'/../../../config/ProjectConfiguration.class.php');
    $configuration = ProjectConfiguration::getApplicationConfiguration('public', 'prod', true);
    sfContext::createInstance($configuration);

    $liveLang = $arguments['live_lang'];
    $langToDeploy = $arguments['lang_to_deploy'];

    $liveLangs = SfConfig::get('app_site_langs');
    $langsUnderDev = SfConfig::get('app_site_langsUnderDev');

    if (in_array($liveLang, $liveLangs) === false)
    {
        die("The live lang doesn't seem to be live!");
    }

    if (in_array($langToDeploy, $langsUnderDev) === false)
    {
        die("You can deploy only a language under development");
    }

    $c = new Criteria();
    $c->add(PcTranslationPeer::LANGUAGE_ID, $langToDeploy);

    $translationsToDeploy = PcTranslationPeer::doSelect($c);

    $i = 0;
    foreach($translationsToDeploy as $translationToDeploy)
    {
        $this->log("Deploying the string " . $translationToDeploy->getStringId() . " from $langToDeploy to $liveLang");
        $liveTranslation = PcTranslationPeer::retrieveByPK($liveLang, $translationToDeploy->getStringId());
        $liveTranslation->setString($translationToDeploy->getString())
                        ->save();
        $translationToDeploy->delete();
        $i++;
    }

    $this->log("All done. $i strings deployed.");
  }
}
