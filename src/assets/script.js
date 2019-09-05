/**
 * CraByFy Universal plugin for Craft CMS
 *
 * CraByFy JS
 *
 * @author    Dunckelfeld
 * @copyright Copyright (c) 2018 Dunckelfeld
 * @link      dunckelfeld.de
 * @package   CraByFyUniversal
 * @since     1.0.0
 */
(function () {

    // *************************
    // DEPLOYMENT TRIGGERS
    // *************************

    // Deploy buttons that call the url with confirmation
    var deployButtons = document.querySelectorAll("#crabyfy-universal-deploy-live, #crabyfy-universal-deploy-preview");
    for (var i = 0; i < deployButtons.length; i++) {
        deployButtons[i].onclick = function (e) {
            // e.preventDefault();
            if (confirm("Soll das Deployment getriggert werden?\n" + e.target.href)) {
                e.preventDefault();
                callDeployTriggerUrl(e.target.href);
                console.log('Deploy triggered');
            } else {
                console.log('Deploy aborted');
                return false;
            }
        };
    }

    /**
     * Call deploy trigger url.
     *
     * @param url
     */
    function callDeployTriggerUrl(url) {
        fetch(url, {
            method: 'post',
        })
            .then(() => console.log('Called deploy trigger successfully. 🚀'))
            .catch(error => console.log('Called deploy trigger with error.', error));
    }

    // *************************
    // DEPLOYMENT STATUS
    // *************************

    // Adds badges above the sidebar app info.
    var appInfoEl = document.getElementById('app-info');
    var appGlobalSidebarEl = document.getElementById('global-sidebar');
    var appDeployEl = document.createElement('div');

    appDeployEl.classList.add('crabyfy-universal-deploy-status');
    appDeployEl.innerHTML = crabyfyUniversalPreviewDeployStatusBadge;
    appDeployEl.innerHTML += crabyfyUniversalLiveDeployStatusBadge;

    appGlobalSidebarEl.insertBefore(appDeployEl, appInfoEl);
})();
