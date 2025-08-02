/**
 * Admin Common JavaScript Functions
 * This file contains common functions used across admin pages
 */

// Sweet Alert Configuration
const SweetAlertConfig = {
    confirmButton: '#3B82F6', // Blue
    cancelButton: '#6B7280',  // Gray
    successButton: '#10B981', // Green
    errorButton: '#EF4444',   // Red
    warningButton: '#F59E0B'  // Yellow
};

/**
 * Show confirmation dialog before action
 * @param {string} title - Dialog title
 * @param {string} text - Dialog text
 * @param {string} icon - Dialog icon (warning, error, success, info, question)
 * @param {string} confirmButtonText - Confirm button text
 * @param {function} confirmCallback - Function to execute on confirm
 * @param {function} cancelCallback - Function to execute on cancel (optional)
 */
function showConfirmDialog(title, text, icon = 'warning', confirmButtonText = 'Yes', confirmCallback = null, cancelCallback = null) {
    Swal.fire({
        title: title,
        text: text,
        icon: icon,
        showCancelButton: true,
        confirmButtonColor: SweetAlertConfig.confirmButton,
        cancelButtonColor: SweetAlertConfig.cancelButton,
        confirmButtonText: confirmButtonText,
        cancelButtonText: 'Cancel',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed && confirmCallback) {
            confirmCallback();
        } else if (result.isDismissed && cancelCallback) {
            cancelCallback();
        }
    });
}

/**
 * Show success message
 * @param {string} title - Success title
 * @param {string} text - Success text
 */
function showSuccessMessage(title, text = '') {
    Swal.fire({
        title: title,
        text: text,
        icon: 'success',
        confirmButtonColor: SweetAlertConfig.successButton,
        timer: 3000,
        timerProgressBar: true
    });
}

/**
 * Show error message
 * @param {string} title - Error title
 * @param {string} text - Error text
 */
function showErrorMessage(title, text = '') {
    Swal.fire({
        title: title,
        text: text,
        icon: 'error',
        confirmButtonColor: SweetAlertConfig.errorButton
    });
}

/**
 * Confirm delete action
 * @param {string} itemName - Name of item to delete
 * @param {function} deleteCallback - Function to execute on confirm
 */
function confirmDelete(itemName, deleteCallback) {
    showConfirmDialog(
        'Are you sure?',
        `Once you deleted it, you can revert it ${itemName}.`,
        'warning',
        'Yes, delete it!',
        deleteCallback
    );
}

/**
 * Confirm restore action
 * @param {string} itemName - Name of item to restore
 * @param {function} restoreCallback - Function to execute on confirm
 */
function confirmRestore(itemName, restoreCallback) {
    showConfirmDialog(
        'Restore Item',
        `Are you sure you want to restore ${itemName}?`,
        'question',
        'Yes, restore it!',
        restoreCallback
    );
}

/**
 * Handle navigation with confirmation
 * @param {string} url - URL to navigate to
 * @param {string} title - Confirmation title
 * @param {string} text - Confirmation text
 */
function confirmNavigation(url, title = 'Navigate away?', text = 'Are you sure you want to leave this page?') {
    showConfirmDialog(
        title,
        text,
        'question',
        'Yes, continue',
        function () {
            window.location.href = url;
        }
    );
}

/**
 * Handle form submission with confirmation
 * @param {string} formId - Form ID to submit
 * @param {string} title - Confirmation title
 * @param {string} text - Confirmation text
 */
function confirmFormSubmit(formId, title, text, confirmButtonText = 'Submit') {
    showConfirmDialog(
        title,
        text,
        'question',
        confirmButtonText,
        function () {
            document.getElementById(formId).submit();
        }
    );
}

/**
 * Initialize common admin functionality
 */
document.addEventListener('DOMContentLoaded', function () {
    // Add click handlers for detail links that might show localhost
    const detailLinks = document.querySelectorAll('a[href*="detail"], a[href*="show"], a[href*="edit"]');

    detailLinks.forEach(link => {
        const originalHref = link.getAttribute('href');

        // Skip view details links (eye icons) - they should navigate directly without confirmation
        if (link.hasAttribute('title') && link.getAttribute('title') === 'View Details') {
            return; // Skip adding confirm dialog to View Details links
        }

        // Check if this might be a detail/edit link that could show localhost in development
        if (originalHref && (originalHref.includes('detail') || originalHref.includes('show') || originalHref.includes('edit'))) {
            link.addEventListener('click', function (e) {
                e.preventDefault();

                // Extract item name/type from URL or context
                let itemType = 'this item';
                if (originalHref.includes('customer')) itemType = 'customer details';
                else if (originalHref.includes('order')) itemType = 'order details';
                else if (originalHref.includes('service')) itemType = 'service details';
                else if (originalHref.includes('quote')) itemType = 'quote request details';
                else if (originalHref.includes('inventory')) itemType = 'inventory details';

                confirmNavigation(
                    originalHref,
                    `View ${itemType}`,
                    `Do you want to view ${itemType}?`
                );
            });
        }
    });

    // Initialize Lucide icons
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
});
