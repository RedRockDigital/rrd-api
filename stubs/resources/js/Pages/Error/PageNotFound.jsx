import React from "react";
import { Link } from "react-router-dom";
import { PrimaryButton, useLanguage } from "rrd-ui";

const PageNotFound = () => {
    const { c } = useLanguage();

    return (
        <div className="h-screen bg-white px-4 py-16 sm:px-6 sm:py-24 md:grid md:place-items-center lg:px-8">
            <div className="mx-auto max-w-max">
                <main className="sm:flex">
                    <p className="text-4xl font-bold tracking-tight text-indigo-600 sm:text-5xl">404</p>
                    <div className="sm:ml-6">
                        <div className="sm:border-l sm:border-gray-200 sm:pl-6">
                            <h1 className="text-4xl font-bold tracking-tight text-gray-900 sm:text-5xl">
                                {c("error_404_header")}
                            </h1>
                            <p className="mt-1 text-base text-gray-500">
                                {c("error_404_content")}
                            </p>
                        </div>

                        <div className="mt-10 flex space-x-3 sm:border-l sm:border-transparent sm:pl-6">
                            <Link
                                to="/"
                            >
                                <PrimaryButton>
                                    {c("error_404_home_button")}
                                </PrimaryButton>
                            </Link>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    );
};

export default PageNotFound;
