import { Auth, Guest, HasScope, Onboarded, TwoFactor, HasVerified, PaymentFailed } from "rrd-ui";

import Home from "@/Pages/Home";

import Roadmap from "@/Pages/Marketing/Roadmap";
import Consultancy from "@/Pages/Marketing/Consultancy";
import Terms from "@/Pages/Marketing/Legal/Terms";
import Privacy from "@/Pages/Marketing/Legal/Privacy";
import Cookies from "@/Pages/Marketing/Legal/Cookies";
import Contact from "@/Pages/Marketing/Contact";
import Pricing from "@/Pages/Marketing/Pricing";
import Blog from "@/Pages/Marketing/Blog";
import BlogRead from "@/Pages/Marketing/Blog/Read";

import Login from "@/Pages/Auth/Login";
import LoginChallenge from "@/Pages/Auth/LoginChallenge";
import Logout from "@/Pages/Auth/Logout";
import ForgotPassword from "@/Pages/Auth/Password/Forgot";
import ResetPassword from "@/Pages/Auth/Password/Reset";

import Register from "@/Pages/Register";
import Verification from "@/Pages/Register/Verification";
import Verify from "@/Pages/Verify";

import Dashboard from "@/Pages/Dashboard";

import SettingsProfile from "@/Pages/Settings/Profile";
import SettingsPassword from "@/Pages/Settings/Password";
import SettingsApiKeys from "@/Pages/Settings/ApiKeys";
import SettingsNotifications from "@/Pages/Settings/Notifications";
import SettingsTwoFactor from "@/Pages/Settings/TwoFactor";

import TeamsCreate from "@/Pages/Team/Create";

import TeamSettings from "@/Pages/Team/Settings";
import TeamBilling from "@/Pages/Team/Billing";
import TeamBillingOnboarding from "@/Pages/Team/Billing/Onboarding";
import TeamBillingFailed from "@/Pages/Team/Billing/Failed";
import TeamUsers from "@/Pages/Team/Users";

import TeamOnboarding from "@/Pages/Team/Onboarding";

const routes = [
    { path: "/", component: Home, guards: [Guest]},

    { path: "/roadmap", component: Roadmap },
    { path: "/consultancy", component: Consultancy },
    { path: "/legal/terms", component: Terms },
    { path: "/legal/privacy", component: Privacy },
    { path: "/legal/cookies", component: Cookies },
    { path: "/contact", component: Contact },
    { path: "/pricing", component: Pricing },
    { path: "/blogs", component: Blog },
    { path: "/blogs/read/:id/:title", component: BlogRead },

    { path: "/register", component: Register, guards: [Guest]},
    { path: "/verify-account/:user/:token", component: Verify },

    { path: "/login", component: Login, guards: [Guest]},
    { path: "/login/challenge", component: LoginChallenge, guards: [Auth]},
    { path: "/logout", component: Logout, guards: [Auth]},

    { path: "/password/forgot", component: ForgotPassword, guards: [Guest]},
    { path: "/password/reset/:token", component: ResetPassword, guards: [Guest]},

    { path: "/verification", component: Verification, guards: [Auth]},

    { path: "/dashboard", component: Dashboard, guards: [Auth, TwoFactor, HasVerified, PaymentFailed, Onboarded]},

    { path: "/settings/profile", component: SettingsProfile, guards: [Auth, TwoFactor, HasVerified, PaymentFailed, Onboarded]},
    { path: "/settings/password", component: SettingsPassword, guards: [Auth, TwoFactor, HasVerified, PaymentFailed, Onboarded]},
    { path: "/settings/api-keys", component: SettingsApiKeys, guards: [Auth, TwoFactor, HasVerified, PaymentFailed, Onboarded]},
    { path: "/settings/notifications", component: SettingsNotifications, guards: [Auth, TwoFactor, HasVerified, PaymentFailed, Onboarded]},
    { path: "/settings/two-factor", component: SettingsTwoFactor, guards: [Auth, TwoFactor, HasVerified, PaymentFailed, Onboarded]},

    { path: "/team/create", component: TeamsCreate, guards: [Auth, HasVerified, PaymentFailed, Onboarded]},

    { path: "/team/settings", component: TeamSettings, guards: [Auth, TwoFactor, HasVerified, PaymentFailed, Onboarded, { guard: HasScope, props: { scope: "team.manage" } }]},
    { path: "/team/billing", component: TeamBilling, guards: [Auth, TwoFactor, HasVerified, Onboarded, { guard: HasScope, props: { scope: "team.manage" } }]},
    { path: "/team/billing/failed", component: TeamBillingFailed, guards: [Auth, TwoFactor, HasVerified, Onboarded]},
    { path: "/team/billing/onboarding", component: TeamBillingOnboarding, guards: [Auth, TwoFactor, HasVerified, Onboarded, { guard: HasScope, props: { scope: "team.manage" } }]},
    { path: "/team/users", component: TeamUsers, guards: [Auth, TwoFactor, HasVerified, PaymentFailed, Onboarded, { guard: HasScope, props: { scope: "team.manage" } }]},

    { path: "/team/onboarding", component: TeamOnboarding, guards: [Auth, TwoFactor, PaymentFailed, HasVerified]},
];

export default routes;
