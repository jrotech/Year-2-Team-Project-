// src/ContactUsForm.js
import React, { useState } from 'react';
import { createRoot } from "react-dom/client";
import { Notification } from '@mantine/core';
import { MantineProvider } from '@mantine/core';

function ContactUsForm() {
  const [showNotification, setShowNotification] = useState(false);
  const [errors, setErrors] = useState({});

  // Simple email validation regex function
  const validateEmail = (email) => {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(String(email).toLowerCase());
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    setErrors({}); // Clear previous errors

    // Gather form data
    const formData = new FormData(e.target);
    const data = Object.fromEntries(formData.entries());

    // Client-side validation for the email field
    const newErrors = {};
    if (!data.email || !validateEmail(data.email)) {
      newErrors.email = "Please enter a valid email address.";
    }
    // Optionally, add more validations for other fields

    // If there are validation errors, do not submit and update state
    if (Object.keys(newErrors).length > 0) {
      setErrors(newErrors);
      return;
    }

    // Get CSRF token from the meta tag
    const csrfToken = document.head.querySelector('meta[name="csrf-token"]').content;
    try {
      const response = await fetch('/contact', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'X-CSRF-TOKEN': csrfToken,
        },
        body: JSON.stringify(data)
      });

      if (response.ok) {
        e.target.reset();
        setShowNotification(true);
        setTimeout(() => {
          setShowNotification(false);
        }, 5000);
      } else {
        // Optionally log the error details
        const errorData = await response.json();
        console.error('Error submitting the form data:', errorData);
      }
    } catch (error) {
      console.error('Error submitting the form data', error);
    }
  };

  return (
    <MantineProvider theme={{ colorScheme: 'light' }}>
      <main className="mb-20">
        {showNotification && (
          <Notification
            onClose={() => setShowNotification(false)}
            color="teal"
            title="Success"
            className="mb-8"
          >
            Your message has been sent successfully!
          </Notification>
        )}
        <section className="flex flex-col md:flex-row px-5 md:px-20 lg:px-40 2xl:px-60 mt-20 justify-between">
          <section className="w-full flex flex-col justify-center text-center md:text-left md:max-w-2/3">
            <h1 className="text-4xl">Get In Touch</h1>
            <p>Please fill in your details and a member of our team will be in touch shortly.</p>
            <form
              className="flex flex-wrap w-full md:max-w-[580px] text-left"
              onSubmit={handleSubmit}
              id="contactForm"
            >
              {["name", "subject", "email", "phone_number"].map((field, i) => (
                <section className="flex flex-col w-full md:w-[250px] md:max-w-[250px] mx-5 my-4" key={i}>
                  <label className="capitalize mb-2" htmlFor={field}>
                    {field === "phone_number" ? "phone number" : field}
                  </label>
                  <input
                    className="border-2 border-foreground rounded-[5px] h-10 px-2"
                    type={field === "email" ? "email" : "text"}
                    id={field}
                    name={field}
                    required
                  />
                  {field === "email" && errors.email && (
                    <span className="text-red-500 text-sm">{errors.email}</span>
                  )}
                </section>
              ))}
              <section className="flex flex-col xl:max-w-full w-full md:max-w-[250px] xl:w-full mx-5 my-4">
                <label className="capitalize mb-2" htmlFor="message">message</label>
                <textarea
                  className="border-2 border-foreground rounded-[5px] h-32 resize-none"
                  id="message"
                  name="message"
                  required
                />
              </section>
              <div className="w-full md:w-[250px] mt-10 ml-5 mr-5">
                <button type="submit" className="border-2 border-foreground rounded-[5px] w-full h-12">
                  Submit Message
                </button>
              </div>
              <p className="text-sm pl-2 py-10 text-center md:text-left">
                Your personal data is used only for the purpose of responding to your query. For more information on how Tech Forge processes personal data, please read our <a className="text-sm text-black underline" href="/">Privacy Policy here</a>.
              </p>
            </form>
          </section>
          <map className="flex flex-col md:max-w-1/3 md:w-1/3 my-10 gap-y-2">
            <h1 className="text-[24px]">Find Us</h1>
            <p>Paying us a visit? Find us on the map below.</p>
            <iframe
              width="100%"
              height="500"
              src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2043.039308298201!2d-1.8889252026901953!3d52.48643424055124!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0000000000000000%3A0x9a670ba18e08a084!2sAston+University!5e0!3m2!1sen!2suk!4v1453479345969"
            ></iframe>
          </map>
        </section>
        <section className="flex w-screen justify-center mt-20 px-5 md:px-20 lg:px-40 2xl:px-60">
          <ul className="flex justify-around flex-wrap w-full gap-y-5">
            <li className="flex gap-4">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round">
                <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z" />
              </svg>
              +44 777 777 7777
            </li>
            <li className="flex gap-4">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round">
                <path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0" />
                <circle cx="12" cy="10" r="3" />
              </svg>
              Aston Uni
            </li>
            <li className="flex gap-4">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round">
                <rect width="20" height="16" x="2" y="4" rx="2" />
                <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7" />
              </svg>
              info@tech_forge.co.uk
            </li>
            <li className="flex gap-4">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round">
                <circle cx="12" cy="12" r="10" />
                <polyline points="12 6 12 12 16 14" />
              </svg>
              07.00 am - 09.00 pm
            </li>
          </ul>
        </section>
      </main>
    </MantineProvider>
  );
}

export default ContactUsForm;

const rootElement = document.getElementById("contact");
const root = createRoot(rootElement);
root.render(<ContactUsForm {...Object.assign({}, rootElement.dataset)} />);
