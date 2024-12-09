// THIS IS THE SIDEBAR COMPONENT FOR THE DASHBOARD

//
// THIS COMPONENT USES MANTINE MAKE SURE THE COMPONENT HAS ACCESS TO MANTINE PROVIDER!!!!
//

import React from 'react'
import { Stack, RangeSlider, Title, Checkbox } from '@mantine/core'
import { Stars } from '../components/Stars'

export default function Sidebar() {
  const toggleSidebarRef = React.useRef(null);
  const links = [
    { name: 'My Profile', href: '/dashboard' },
    { name: 'My Orders', href: '/dashboard/orders' },
    { name: 'My Cart', href: '/basket' },
    { name: 'Contact Us', href: '/dashboard/contact' },
  ];
  return (
    <div>
      {/* hamburger */}
      <input type="checkbox" id="sidebarHamburger" className="peer hidden" ref={toggleSidebarRef} />
      <label htmlFor="sidebarHamburger" className="cursor-pointer absolute top-[-50px] left-10 peer-checked:hidden">
        {[1, 2, 3].map((_, i) => (
          <span
            key={i}
            className="min-[960px]:hidden  block w-8 mb-1 bg-black h-1 origin-top-right transition-transform"
          ></span>
        ))}
      </label>

      <Stack className="max-w-[500px] min-w-[300px] sm:w-[400px] w-[300px] bg-white rounded-md pt-7 px-14 gap-7 h-screen sticky top-10 max-[960px]:peer-checked:translate-x-[-80%] max-[960px]:translate-x-[100%] transition-all duration-300 max-[960px]:absolute z-20 ">

        <button onClick={() => toggleSidebarRef.current.click()} className="min-[960px]:hidden"><svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round" className="icon icon-tabler icons-tabler-outline icon-tabler-xbox-x"><path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M12 21a9 9 0 0 0 9 -9a9 9 0 0 0 -9 -9a9 9 0 0 0 -9 9a9 9 0 0 0 9 9z" /><path d="M9 8l6 8" /><path d="M15 8l-6 8" /></svg></button>


        <Title order={2}>Dashboard</Title>
        {
          links.map((link, i) => (
            <a href={link.href}>
              <Title order={6} href={link.href} className="relative hover:text-main-accent transition-color duration-300 font-normal before:content-[''] before:absolute before:h-[2px] before:w-full before:bottom-0 before:left-0 hover:before:right-0 before:bg-main-accent before:scale-x-0 before:transition-all before:ease-linear before:duration-300 hover:before:scale-x-100 capitalize">
                {link.name}
              </Title>
            </a>
          ))
        }
        <hr />
        <a href="/profile/manage-profile">
          <Title order={6} className="hover:underline cursor-pointer">
            Change Personal Details
          </Title>
        </a>
        <a href="/profile/manage-profile">
          <Title order={6} className="hover:underline cursor-pointer">
            Change Password
          </Title>
        </a>
        <a href="/logout">
          <Title order={6} className="hover:underline cursor-pointer">
            Logout
          </Title>
        </a>
      </Stack>
    </div>
  )
}

