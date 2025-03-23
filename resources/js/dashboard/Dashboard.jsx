/********************************
Developer: Mihail Vacarciuc , Robert Oros
University ID: 230238428, 230237144
********************************/

import React, { useState, useEffect } from 'react';
import { createRoot } from 'react-dom/client';
import Order from './Order';
import Sidebar from '../components/Sidebar';
import { MantineProvider, Flex, Stack, Title } from '@mantine/core';
import { theme } from '../mantine';
import Profile from './Profile';
import Contact from './Contact';
import Review from './Rate';
import Related from '../components/Related';
function Dashboard(props) {
	const customer = JSON.parse(document.getElementById('dashboard').dataset.customer);
	const invoices = JSON.parse(document.getElementById('dashboard').dataset.invoices);
	console.log(invoices);

	// State for API fetched data
	const [lastProduct, setLastProduct] = useState(null);
	const [relatedProducts, setRelatedProducts] = useState([]);

	useEffect(() => {
		const fetchLastProductData = async () => {
			try {
				const response = await fetch('/api/categorylastproduct');
				if (!response.ok) {
					throw new Error('No data available');
				}
				const data = await response.json();
	
				if (data.success) {
					setLastProduct(data.last_product);
					setRelatedProducts(data.related_products || []);
				} else {
					setLastProduct(null);
					setRelatedProducts([]);
				}
			} catch (error) {
				setLastProduct(null);
				setRelatedProducts([]);
			}
		};
	
		fetchLastProductData();
	}, []);

	// Safely access address and other invoice details
	const address = invoices.length > 0 && invoices[0].address ? invoices[0].address : 'No address available';

	return (
		<MantineProvider theme={theme}>
			<Flex className="max-w-screen justify-between m-32 relative">
				<Flex className="items-center justify-center w-full">
					<Stack className="gap-20 flex-wrap justify-center mx-5">

						<Title className="text-main-accent underline">Profile</Title>
						<Profile
							name={customer.customer_name}
							email={customer.email}
							address={address}
							phone={customer.phone_number}
							orders={invoices.length}
							spent={invoices.reduce((total, invoice) => total + parseFloat(invoice.amount || 0), 0)}
							points={Math.floor(invoices.reduce((total, invoice) => total + parseFloat(invoice.amount || 0), 0) / 10)}
						/>

						<Title className="text-main-accent underline" mt="40">Recent Orders</Title>
						<Stack gap="50">
							{invoices.length > 0 ? (
								invoices.reverse().map((invoice) => (
									<Order
										key={invoice.invoice_id}
										name={`Invoice #${invoice.invoice_id}`}
										id={invoice.invoice_id}
										order_date={invoice.created_at}
										total={invoice.amount}
										invoice_orders={invoice.invoice_orders}
										status={invoice.status}
									/>
								))
							) : (
								<p>No orders available.</p>
							)}
						</Stack>

						<Stack className="py-10">
							<Title className="text-center !text-5xl" mb="10" order={1}>Reviews</Title>
							{lastProduct ? (
								<Review
									img_url={lastProduct.image}
									name={lastProduct.name}
									product_id={lastProduct.id}
								/>
							) : (
								<p>No product available for review.</p>
							)}
						</Stack>

						<Stack>
							<Title className="text-center !text-5xl" mb="10" order={1}>Related Products</Title>
							<Flex gap="20">
								{relatedProducts.length > 0 ? (
									relatedProducts.slice(0,3).map((prod, i) => (
										<Related
											key={i}
											name={prod.name}
											price={prod.price}
											id={prod.id}
											description={prod.description || 'No description available.'}
											img_url={prod.image}
										/>
									))
								) : (
									<p>No related products found.</p>
								)}
							</Flex>
						</Stack>

					</Stack>
				</Flex>
				<Sidebar />
			</Flex>
		</MantineProvider>
	);
}

export default Dashboard;

const rootElement = document.getElementById('dashboard');
const root = createRoot(rootElement);

root.render(<Dashboard {...Object.assign({}, rootElement.dataset)} />);
