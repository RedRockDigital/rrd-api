import React from "react";
import { createRoot } from "react-dom/client";
import { ConfigProvider, Client } from "rrd-ui";

import "@/../sass/app.scss";

import routes from "@/Config/routes";
import lang from "@/Config/lang";

import PageNotFound from "@/Pages/Error/PageNotFound";

window.sentryDsn = import.meta.env.VITE_SENTRY_LARAVEL_DSN;

createRoot(document.getElementById("app"))
    .render(
        <ConfigProvider
            config={{
                routes,
                defaultRoute: <PageNotFound />,
                languages: lang,
                apiRoute: import.meta.env.VITE_API_BASE_URL,
                fathomAnalytics: import.meta.env.VITE_FATHOM_ANALYTICS,
                env: import.meta.env.VITE_APP_ENV,
                features: import.meta.env.VITE_USE_FEATURES,
                featuresEnabled: window?.app?.feature_flags ? Object.keys(window.app.feature_flags) : [],
                oauthClientId: import.meta.env.VITE_CLIENT_ID,
                oauthClientSecret: import.meta.env.VITE_CLIENT_SECRET,
                assetUrl: window.asset_url,
                pusher: {
                    app_key: import.meta.env.VITE_PUSHER_APP_KEY,
                    host: import.meta.env.VITE_PUSHER_HOST,
                    port: import.meta.env.VITE_PUSHER_PORT,
                    scheme: import.meta.env.MIX_PUSHER_SCHEME,
                    auth_endpoint: `${import.meta.env.VITE_API_BASE_URL}/broadcasting/auth`,
                    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
                },
            }}
        >
            <Client />
        </ConfigProvider>
    );
