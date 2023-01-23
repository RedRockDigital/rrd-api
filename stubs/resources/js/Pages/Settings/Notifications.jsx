import React, { useEffect, useState } from "react";

import SettingsLayout from "@/Components/Layouts/SettingsLayout";
import { Card, CardHeader, CardBody, Loading, Toggle, Label, useRequest, useLanguage, useToast } from "rrd-ui";

import informableOptions from "@/Config/Options/informableOptions";

const Notifications = () => {
    const { c } = useLanguage();
    const { get, patch } = useRequest();
    const { success } = useToast();

    const [informables, setInformables] = useState([]);
    const [loading, setLoading] = useState();

    useEffect(() => {
        (async () => {
            setLoading(true);
            const request = await get("/me/informable");

            if (request.success) {
                setInformables(request.data.data.map(item => item.name));
                setLoading(false);
            }
        })();
    }, []);

    const handleToggleInformable = async (event) => {
        const request = await patch("/me/informable", {
            informable: event.name,
        });

        if (request.success) {
            if (request.status === 204) {
                setInformables(informables => informables.filter(item => item !== event.name));
            } else if (request.status === 201) {
                setInformables([
                    ...informables,
                    event.name,
                ]);
            }

            success(c("settings_notifications_success"));
        }
    };

    return (
        <SettingsLayout>
            <form>
                <Card>
                    <CardHeader>
                        {c("settings_notifications_header")}
                    </CardHeader>

                    {loading && (
                        <CardBody>
                            <Loading />
                        </CardBody>
                    )}

                    {!loading && (
                        <div className="px-4 py-3 sm:p-4">
                            <div className="divide-y divide-gray-200">
                                {informableOptions.map(option => (
                                    <div className="py-2 relative flex items-center" key={option.value}>
                                        <div className="min-w-0 flex-1 text-sm">
                                            <Label label={c(option.label)} />

                                            <p className="text-gray-500">
                                                {c(option.description)}
                                            </p>
                                        </div>
                                        <div className="ml-3 flex h-5 items-center">
                                            <Toggle
                                                name={option.value}
                                                onChange={handleToggleInformable}
                                                value={informables && informables.indexOf(option.value) !== -1}
                                            />
                                        </div>
                                    </div>
                                ))}
                            </div>
                        </div>
                    )}
                </Card>
            </form>
        </SettingsLayout>
    );
};

export default Notifications;
