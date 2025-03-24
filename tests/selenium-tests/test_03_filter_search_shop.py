from selenium import webdriver
from selenium.webdriver.chrome.service import Service
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from webdriver_manager.chrome import ChromeDriverManager
import time
import pytest


def test_03_filter_search_shop():
    # setup driver and wait
    service = Service(ChromeDriverManager().install())
    options = webdriver.ChromeOptions()
    driver = webdriver.Chrome(service=service, options=options)
    wait = WebDriverWait(driver, 10)

    # go to the shop page
    driver.get("http://localhost:8000/shop")
    driver.maximize_window()

    # wait for the product grid to load
    wait.until(EC.presence_of_element_located((By.CLASS_NAME, "mantine-Stack-root")))

    # -------------------
    # apply category filter: gpu
    # -------------------
    gpu_checkbox_label = wait.until(EC.presence_of_element_located((By.XPATH, "//h5[text()='GPU']")))
    gpu_checkbox_input = gpu_checkbox_label.find_element(By.XPATH, "./following-sibling::div//input[@type='checkbox']")
    # click it using JavaScript to avoid Mantine's custom styling interference
    driver.execute_script("arguments[0].click();", gpu_checkbox_input)

    # wait for products to update
    time.sleep(2)  

    product_titles = driver.find_elements(By.CSS_SELECTOR, ".mantine-Title-root")

    #check that product results exist after applying category filter
    assert len(product_titles) > 0, "no products returned for 'GPU' category"

    # -------------------
    # search for a product (e.g. 'geforce')
    # -------------------
    search_input = driver.find_element(By.CSS_SELECTOR, "input[placeholder='Search products...']")
    search_input.clear()
    search_input.send_keys("GEFORCE")

    time.sleep(1)  # give time for debounce or filter to trigger
    driver.find_element(By.CSS_SELECTOR, "body").click()  # blur input to trigger request if needed

    time.sleep(2)  # wait for update

    product_titles = driver.find_elements(By.CSS_SELECTOR, ".mantine-Title-root")
    #verify that at least one product contains 'geforce' in the name
    assert any("geforce" in title.text.lower() for title in product_titles), "no products matched 'GEFORCE' search"

  

    # -------------------
    # check in-stock only filter
    # -------------------
    in_stock_label = wait.until(EC.presence_of_element_located((By.XPATH, "//h5[text()='Only Show In Stock Products']")))
    in_stock_input = in_stock_label.find_element(By.XPATH, "./following-sibling::div//input[@type='checkbox']")
    # click it using JavaScript to avoid Mantine's custom styling interference
    driver.execute_script("arguments[0].click();", in_stock_input)

    time.sleep(2)

    product_cards = driver.find_elements(By.CSS_SELECTOR, ".mantine-Flex-root .mantine-Stack-root")
    #ensure in-stock filter shows at least one result
    assert len(product_cards) > 0, "in-stock filter returned no products"

    # -------------------
    # reset search bar to show more results
    # -------------------
    search_input = driver.find_element(By.CSS_SELECTOR, "input[placeholder='Search products...']")
    search_input.clear()
    driver.find_element(By.CSS_SELECTOR, "body").click()
    time.sleep(2)


   
    # -------------------
    # done
    # -------------------
    driver.quit()
