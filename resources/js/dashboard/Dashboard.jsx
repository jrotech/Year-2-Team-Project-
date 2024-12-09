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

	// State for API fetched data
	const [lastProduct, setLastProduct] = useState(null);
	const [relatedProducts, setRelatedProducts] = useState([]);

	useEffect(() => {
		// Fetch the last product and related products from the API using async/await
		const fetchLastProductData = async () => {
			try {
				const response = await fetch('/api/categorylastproduct');
				const data = await response.json();

				if (data.success) {
					setLastProduct(data.last_product);
					setRelatedProducts(data.related_products || []);
				} else {
					// If not successful, handle errors or set defaults
					setLastProduct(null);
					setRelatedProducts([]);
				}
			} catch (error) {
				console.error('Error fetching last product data:', error);
				setLastProduct(null);
				setRelatedProducts([]);
			}
		};

		// Call the async function
		fetchLastProductData();
	}, []);

	return (
		<MantineProvider theme={theme}>
			<Flex className="max-w-screen justify-between m-32 relative">
				<Flex className="items-center justify-center w-full">
					<Stack className="gap-20 flex-wrap justify-center mx-5">

						<Title className="text-main-accent underline">Profile</Title>
						<Profile
							name={customer.customer_name}
							email={customer.email}
							address={invoices[0].address}
							phone={customer.phone_number}
							orders={invoices.length}
							spent={invoices.reduce((total, invoice) => total + parseFloat(invoice.amount || 0), 0)}
							points={Math.floor(invoices.reduce((total, invoice) => total + parseFloat(invoice.amount || 0), 0) / 10)}
						/>

						<Title className="text-main-accent underline" mt="40">Recent Orders</Title>
						<Stack gap="50">
							{invoices.length > 0 ? (
								invoices.map((invoice) => (
									<Order
										key={invoice.invoice_id}
										name={`Invoice #${invoice.invoice_id}`}
										id={invoice.invoice_id}
										order_date={invoice.created_at}
										total={invoice.amount}
										invoice_orders={invoice.invoice_orders}
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
									relatedProducts.map((prod, i) => (
										<Related
											key={i}
											name={prod.name}
											price={prod.price}
											id={prod.id}
											description={prod.description || 'No description available.'}
											img_url={"storage/" + prod.image}
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
