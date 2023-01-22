import { DateTime } from "luxon";

import { faTrash } from "@fortawesome/free-solid-svg-icons/faTrash";
import { faDownload } from "@fortawesome/free-solid-svg-icons/faDownload";
import { faPencil } from "@fortawesome/free-solid-svg-icons/faPencil";

const apiKeys = [
    {
        label_ref: "api_keys_table_name",
        field: "name",
        format: (value) => value ?? "N/A",
    },
    {
        label_ref: "api_keys_table_expires_at",
        field: "expires_at",
        format: (expiresAt) => expiresAt ? DateTime.fromISO(expiresAt).toLocaleString(DateTime.DATETIME_MED) : "N/A",
    },
    {
        label_ref: "misc_actions",
        actions: [
            {
                type: "delete",
                icon: faTrash,
            },
        ],
    },
];

const invoices = [
    {
        label_ref: "teams_billing_invoices_table_date",
        field: "date",
        format: (date) => date ? DateTime.fromISO(date).toLocaleString(DateTime.DATETIME) : "N/A",
    },
    {
        label_ref: "teams_billing_invoices_table_price",
        field: "amount_paid",
        format: (price) => `£${price}`,
    },
    {
        label_ref: "teams_billing_invoices_table_actions",
        actions: [
            {
                type: "primary_button",
                icon: faDownload,
                linkType: "download_invoice",
                download: "invoice.pdf",
            },
        ],
    },
];

const teamUsers = [
    {
        label_ref: "team_users_table_email",
        field: "email",
    },
    {
        label_ref: "team_users_table_group",
        field: "group.name",
    },
    {
        label_ref: "teams_billing_invoices_table_actions",
        actions: [
            {
                type: "primary_button",
                icon: faPencil,
                modal: "edit",
            },
            {
                type: "delete",
                icon: faTrash,
            },
        ],
    },
];

export {
    apiKeys,
    invoices,
    teamUsers,
};
