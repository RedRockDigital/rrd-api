import React, { useState, useEffect } from "react";
import { Link, useParams } from "react-router-dom";
import { DateTime } from "luxon";
import ReactMarkdown from "react-markdown";
import { Loading, Container, ErrorState, useRequest, useLanguage } from "rrd-ui";

import MarketingLayout from "@/Components/Layouts/Marketing";
import { Hero } from "@/Components/Partials";

import blogAuthorImages from "@/Config/blogAuthorImages";

const Read = () => {
    const { c } = useLanguage();
    const { get } = useRequest();
    const params = useParams();

    const [blog, setBlog] = useState(null);
    const [working, setWorking] = useState(true);
    const [error, setError] = useState(false);

    useEffect(() => {
        (async () => {
            setWorking(true);

            const request = await get(`blogs/${params?.id}`);

            if (request.success) {
                setBlog(request.data.data);
            } else {
                setError(true);
            }

            setWorking(false);
        })();
    }, []);

    return (
        <MarketingLayout>
            <Hero>
                <div className="text-center">
                    <h1 className="text-4xl tracking-tight font-extrabold text-gray-800 sm:text-5xl md:text-6xl">
                        {blog?.title ?? c("blog_title")}
                    </h1>
                </div>
            </Hero>

            <Container>
                {working && (
                    <Loading />
                )}

                {error && (
                    <ErrorState />
                )}
            </Container>

            {!working && !error && blog && (
                <div className="relative overflow-hidden bg-white py-16">
                    <Container sizeClassName="max-w-4xl space-y-4">
                        <div className="flex-shrink-0">
                            <img
                                className="w-full object-cover"
                                src={blog.featured_image_url}
                                alt=""
                            />
                        </div>

                        <div className="flex flex-1 flex-col justify-between bg-white py-6">
                            <div className="flex-1">
                                <p className="text-sm flex space-x-4 font-medium text-indigo-600">
                                    {blog.tags.map(tag => (
                                        <Link
                                            key={`category=${tag?.id}`}
                                            to={`/blogs?category=${tag?.name?.en}`}
                                            className="cursor-pointer hover:underline"
                                        >
                                            {tag?.name?.en}
                                        </Link>
                                    ))}
                                </p>
                            </div>
                            <div className="mt-6 flex items-center space-x-3">
                                {blogAuthorImages[blog.author.toLowerCase()] && (
                                    <Link
                                        to={`/blogs?author=${blog.author}`}
                                        className="flex-shrink-0"
                                    >
                                        <span className="sr-only">{blog.author}</span>
                                        <img
                                            className="h-10 w-10 rounded-full"
                                            src={blogAuthorImages[blog.author.toLowerCase()]}
                                            alt={blog.author}
                                        />
                                    </Link>
                                )}
                                <div>
                                    <p className="text-sm font-medium text-gray-900">
                                        <Link
                                            to={`/blogs?author=${blog.author}`}
                                            className="hover:underline cursor-pointer"
                                        >
                                            {blog.author}
                                        </Link>
                                    </p>
                                    <div className="flex space-x-1 text-sm text-gray-500">
                                        <time dateTime={blog.published_at}>
                                            {DateTime.fromISO(blog.published_at).toLocaleString(DateTime.DATE_MED)}
                                        </time>
                                        <span aria-hidden="true">&middot;</span>
                                        <span>{blog.estimate_read_time} min read</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <ReactMarkdown className="prose lg:prose-lg">
                            {blog?.body}
                        </ReactMarkdown>
                    </Container>
                </div>
            )}
        </MarketingLayout>
    );
};

export default Read;
