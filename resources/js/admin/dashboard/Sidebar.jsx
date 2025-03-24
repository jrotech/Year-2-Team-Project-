import React from "react";
import { Burger, Overlay, Transition } from "@mantine/core";
import { useDisclosure } from "@mantine/hooks";
import { useClickOutside } from "@mantine/hooks";

export default function SideBar() {
  const [opened, { toggle, close }] = useDisclosure(false);
  const ref = useClickOutside(close);

  const navLinks = [
    {
      url: "/",
      name: "Home",
    },
    {
      url: "/dashboard",
      name: "Dashboard",
    },
    {
      url: "/dashboard/invoices",
      name: "Invoices",
    },
    {
      url: "/dashboard/customers",
      name: "Customers",
    },
    {
      url: "/dashboard/products",
      name: "Products",
    },
    {
      url: "/dashboard/stock",
      name: "Stock",
    },
  ];
  return (
    <>
      {opened && (
        <div className="w-screen h-screen fixed z-[1000]">
          <Overlay color="#000" backgroundOpacity={0.85} />
        </div>
      )}
      <div className="fixed top-10 left-10 ">
        <Burger onClick={toggle} opened={opened} />
      </div>
      <Transition mounted={opened} transition="slide-right" duration={300}>
        {transitionStyle => (
          <nav
            className="justify-between w-[330px] flex-col h-screen fixed bg-white px-8 flex"
            style={{ ...transitionStyle, zIndex: 1000 }}
            ref={ref}
          >
            <div className="">
              {navLinks.map(({ url, name }) => {
                return (
                  <div
                    key={url}
                    className="relative text-center text-main-primaryAccent border-b-2 cursor-pointer my-8 before:content-[''] before:absolute before:h-[2px] before:w-full before:bottom-0 before:left-0 before:right-0 before:bg-main-primary before:scale-x-0 before:transition-all before:ease-linear before:duration-300 hover:before:scale-x-100"
                  >
                    <a href={url} className={`text-xl `} onClick={close}>{name}</a>
                  </div>
                );
              })}
            </div>
            {/* <button>Delete Account</button> */}
          </nav>
        )}
      </Transition>
    </>
  );
}
