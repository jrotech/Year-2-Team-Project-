// src/ContactUsForm.js
import React, { useState } from 'react';
import { createRoot } from "react-dom/client";
import { TextInput, Textarea, Button, Notification, Group } from '@mantine/core';
import { MantineProvider } from '@mantine/core';

function About() {
//  const check = 
  const [showNotification, setShowNotification] = useState(false);

  const handleSubmit = (values) => {
    document.getElementById("contactForm").reset();
    setShowNotification(true);
    setTimeout(() => {
      setShowNotification(false);
    }, 5000);
  };

  return (
    <MantineProvider theme={{ colorScheme: 'light' }}>
      <section className="py-20 w-full flex flex-col md:flex-row justify-between items-center px-5 md:px-20 lg:px-40 2xl:px-60">
        <div className="flex flex-col gap-y-11 w-full lg:w-1/2 text-center lg:text-left ">

        <h1 className="text-4xl font-bold">About Us</h1>
        <p>Welcome to Team 32's PC Builder platform!</p>
        <p>
            We are passionate about technology and aim to provide you with the best tools to build your personalized PC.
            Whether you're a seasoned gamer, a professional designer, or just someone looking to get started, we have the
            right components and support to help you make the perfect choice.
        </p>

	<h1 className="text-2xl font-bold my-4">Admin Login</h1>
	<div>
	  <p className="my-2">admin@example.com</p>
	  <p className="my-2">password</p>
	</div>

        <h2 className="text-2xl font-bold my-4">Our Mission</h2>
        <p>
            Our mission is simple: to make custom PC building accessible, easy, and enjoyable for everyone. We combine
            expert advice, high-quality components, and an intuitive PC builder to make the process seamless. Whether
            you're building your first PC or upgrading an existing setup, we’re here to help.
        </p>

        <h2 className="text-2xl font-bold my-4">AI-Powered Recommendations</h2>
        <p>
            Our AI chatbot offers personalized recommendations based on your preferences, making the process of choosing
            components easier and more fun. The chatbot can suggest the best products, configurations, and even help you
            troubleshoot.
        </p>

        <h2 className="text-2xl font-bold my-4">Best Selling Products</h2>
        <p>
            Explore our top-rated and best-selling products, carefully curated to ensure you get the best performance for
            your budget.
        </p>

        <h3 className="text-3xl font-bold my-4">Team 32</h3>
        <p>
            We are a team of tech enthusiasts and developers working together to make PC building fun, efficient, and
            affordable for all.
	</p>
	</div>

        <div className="">
          <div className="relative lg:w-[550px] lg:h-[500px]">
            <img src="/images/logo.png" alt="about_us" layout="fill" objectFit="cover" />
          </div>
        </div>
      </section>
    </MantineProvider>
  );
}

export default About;

const rootElement = document.getElementById("contact");
const root = createRoot(rootElement);
root.render(
    <About {...Object.assign({}, rootElement.dataset)} />
);
