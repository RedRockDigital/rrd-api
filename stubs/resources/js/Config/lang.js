const languages = [
    {
        code: "en-GB",
        fileName: `${import.meta.env.VITE_APP_ENV === "local" ? "/resources/js" : "/build"}/Language/en.js`,
        display: "English",
    },
];

window.test = import.meta.env.VITE_APP_ENV;

export default languages;
