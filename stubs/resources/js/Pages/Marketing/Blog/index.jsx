import React, { useState, useEffect } from "react";
import { Link } from "react-router-dom";
import { faTimes } from "@fortawesome/free-solid-svg-icons/faTimes";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { DateTime } from "luxon";
import { Pagination, Container, Loading, ErrorState, PrimaryButton, useRequest, useLanguage } from "rrd-ui";

import MarketingLayout from "@/Components/Layouts/Marketing";
import { Hero } from "@/Components/Partials";

import blogAuthorImages from "@/Config/blogAuthorImages";

const Blog = () => {
    const { c } = useLanguage();
    const { get } = useRequest();

    const [blogs, setBlogs] = useState(null);
    const [working, setWorking] = useState(true);
    const [error, setError] = useState(false);
    const [filterByCategory, setFilterByCategory] = useState(null);
    const [filterByAuthor, setFilterByAuthor] = useState(null);

    const handleGetData = async (page) => {
        setWorking(true);

        const request = await get("blogs", {
            page,
        });

        if (request.success) {
            setBlogs(request.data);
        } else {
            setError(true);
        }

        setWorking(false);
    };

    useEffect(() => {
        const params = (new URL(document.location)).searchParams;

        params.get("category") && setFilterByCategory(params.get("category"));
        params.get("author") && setFilterByAuthor(params.get("author"));

        handleGetData();
    }, []);

    const handleFilter = (item) => {
        let shouldReturn = true;

        if (filterByCategory && item.tags.map(tag => tag?.name?.en).indexOf(filterByCategory) === -1) {
            shouldReturn = false;
        }

        if (filterByAuthor && item.author !== filterByAuthor) {
            shouldReturn = false;
        }

        return shouldReturn;
    };

    return (
        <MarketingLayout>
            <Hero>
                <div className="text-center">
                    <h1 className="text-4xl tracking-tight font-extrabold text-gray-800 sm:text-5xl md:text-6xl">
                        {c("blog_title")}
                    </h1>
                    <p className="mt-3 max-w-md mx-auto text-base text-gray-500 sm:text-lg md:mt-5 md:text-xl md:max-w-3xl">
                        {c("blog_description")}
                    </p>
                </div>
            </Hero>

            <Container>
                <div className="mt-12 flex space-x-6">
                    {filterByAuthor && (
                        <PrimaryButton onClick={() => setFilterByAuthor(null)}>
                            <FontAwesomeIcon icon={faTimes} className="mr-2" /> <span>Author: {filterByAuthor}</span>
                        </PrimaryButton>
                    )}
                    {filterByCategory && (
                        <PrimaryButton onClick={() => setFilterByCategory(null)}>
                            <FontAwesomeIcon icon={faTimes} className="mr-2" /> <span>Category: {filterByCategory}</span>
                        </PrimaryButton>
                    )}
                </div>

                {error && (
                    <ErrorState />
                )}

                {working && (
                    <Loading />
                )}

                {!error && !working && blogs && (
                    <>
                        <div className="mt-4 grid gap-5 lg:grid-cols-3">
                            {blogs?.data
                                ?.filter(handleFilter)
                                .map(blog => (
                                    <div className="flex flex-col overflow-hidden rounded-lg shadow-lg" key={blog.id}>
                                        <div className="flex-shrink-0">
                                            <img className="h-48 w-full object-cover"
                                                src={blog.featured_image_url}
                                                alt="" />
                                        </div>
                                        <div className="flex flex-1 flex-col justify-between bg-white p-6">
                                            <div className="flex-1">
                                                <p className="text-sm flex space-x-4 font-medium text-indigo-600">
                                                    {blog.tags.map(tag => (
                                                        <span
                                                            key={`category-${tag?.id}`}
                                                            onClick={() => setFilterByCategory(tag?.name?.en)}
                                                            className="cursor-pointer hover:underline"
                                                        >
                                                            {tag?.name?.en}
                                                        </span>
                                                    ))}
                                                </p>

                                                <Link
                                                    to={`/blogs/read/${blog.id}/${blog.title.toLowerCase().split(" ").join("-")}`}
                                                    className="mt-2 block"
                                                >
                                                    <p className="text-xl font-semibold text-gray-900">{blog.title}</p>
                                                    <p className="mt-3 text-base text-gray-500">
                                                        {blog.snippet}
                                                    </p>
                                                </Link>
                                            </div>
                                            <div className="mt-6 flex items-center space-x-3">
                                                {blogAuthorImages[blog.author.toLowerCase()] && (
                                                    <div
                                                        onClick={() => setFilterByAuthor(blog.author)}
                                                        className="flex-shrink-0"
                                                    >
                                                        <span className="sr-only">{blog.author}</span>
                                                        <img
                                                            className="h-10 w-10 rounded-full"
                                                            src={blogAuthorImages[blog.author.toLowerCase()]}
                                                            alt={blog.author}
                                                        />
                                                    </div>
                                                )}

                                                <div>
                                                    <p className="text-sm font-medium text-gray-900">
                                                        <span
                                                            onClick={() => setFilterByAuthor(blog.author)}
                                                            className="hover:underline cursor-pointer"
                                                        >
                                                            {blog.author}
                                                        </span>
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
                                    </div>
                                ))}
                        </div>

                        {blogs.pagination.total === 0 && (
                            <div className="text-center text-gray-500">
                                {c("blogs_empty")}
                            </div>
                        )}

                        {blogs.pagination.total > 0 && (
                            <div className="pt-8 flex justify-center">
                                <Pagination
                                    page={blogs.pagination.current_page}
                                    pageCount={blogs.pagination.last_page}
                                    goToPage={handleGetData}
                                />
                            </div>
                        )}
                    </>
                )}
            </Container>
        </MarketingLayout>
    );
};

export default Blog;
