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
            } else {
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

    // ***************************
    //  DISPLAY DEPLOYMENT STATUS
    // ***************************

    // Adds badges above the sidebar app info to show status.
    var appInfoEl = document.getElementById('app-info');
    var appGlobalSidebarEl = document.getElementById('global-sidebar');
    var appDeployEl = document.createElement('div');

    appDeployEl.classList.add('crabyfy-universal-deploy-status');
    appDeployEl.innerHTML =
        '<div class="crabyfy-universal-deploy-status__item crabyfy-universal-deploy-indicator crabyfy-universal-deploy-indicator--preview"><span>Preview</span></div>'
        + '<div class="crabyfy-universal-deploy-status__item crabyfy-universal-deploy-indicator crabyfy-universal-deploy-indicator--live"><span>Live</span></div>';

    appGlobalSidebarEl.insertBefore(appDeployEl, appInfoEl);

    // ***************************
    //  RECEIVE DEPLOYMENT STATUS
    // ***************************

    /**
     * Change status.
     *
     * @param elements
     * @param status
     */
    function setIndicatorStatus(elements, status) {
        switch (status) {
            case 'success':
                setIndicatorClasses(elements, 'status--success', ['status--running', 'status--error']);
                break;
            case 'running':
                setIndicatorClasses(elements, 'status--running', ['status--success', 'status--error']);
                break;
            case 'failed':
                setIndicatorClasses(elements, 'status--error', ['status--success', 'status--running']);
                break;
            case 'canceled':
            case 'skipped':
            case 'pending':
            default:
                setIndicatorClasses(elements, '', ['status--success', 'status--error', 'status--running']);
                break;
        }
    }

    /**
     * Change classes on elements.
     *
     * @param elements
     * @param addClasses
     * @param removeClasses
     */
    function setIndicatorClasses(elements, addClasses, removeClasses) {
        elements.forEach(function (element) {
            element.classList.remove(removeClasses);
            element.classList.add(addClasses);
        });
    }

    /**
     * Get deployment status.
     *
     * @param url
     * @param updateElements
     */
    function getDeployStatus(url, updateElements) {
        fetch(url, {
            method: 'get',
        })
            .then(response => response.json())
            .then(data => {
                // Grab latest pipeline and use that status
                if (Array.isArray(data)) {
                    var latestPipeline = data.shift();
                    setIndicatorStatus(updateElements, latestPipeline.status);
                }
            })
            .catch(error => console.warn('Called deploy status with error.', error));
    }

    /**
     * Get status of deploy pipelines, main function.
     */
    function getStatus() {
        getDeployStatus(
            crabyfyUniversalPreviewDeployStatusEndpoint,
            document.querySelectorAll(".crabyfy-universal-deploy-indicator--preview")
        );

        getDeployStatus(
            crabyfyUniversalLiveDeployStatusEndpoint,
            document.querySelectorAll(".crabyfy-universal-deploy-indicator--live")
        );
    }

    // Trigger status check directly
    getStatus();

    // Trigger status check every 10 seconds
    setInterval(function () {
        getStatus();
    }, 10000);
})();
