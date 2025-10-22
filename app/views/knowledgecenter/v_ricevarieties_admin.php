<?php require_once APPROOT . '/views/inc/adminheader.php'; ?>


<main class="main-content" id="mainContent">
  <div class="container">
    <h2 class="article-heading">Rice Varieties</h2>
    <p class="article-description">
      Learn about the different types of rice varieties cultivated across regions, their yield potential, and resistance to climate change.
    </p>

    <div class="article-content">

      <!-- Article 1: Bg 352 -->
      <div class="article-box">
        <div class="article-inner">
          <img src="<?php echo URLROOT; ?>/img/bg352.png" alt="Bg 352" class="article-image">
          <div class="article-text-container">
            <h3>Bg 352 (Short Duration)</h3>
            <p class="article-text">
              Bg 352 is a short-duration rice variety that matures in approximately 90 days, making it ideal for regions with limited water availability or short growing seasons. This variety is resistant to several common pests, including brown planthopper, and can tolerate moderate drought conditions. 
              <br><strong>Planting Tips:</strong> Sow seeds in well-prepared, leveled fields with spacing of 20 x 20 cm. Maintain water management for optimal growth.
              <br><strong>Harvesting:</strong> Harvest when grains turn golden yellow and moisture content is around 20%. Allows quick turnover for multiple crops per year.
              <br><strong>Yield:</strong> Expected yield: 4-5 tons per hectare under optimal conditions.
            </p>
            <button class="read-more-btn">Read More</button>
          </div>
        </div>
      </div>

      <!-- Article 2: Suwandel -->
      <div class="article-box">
        <div class="article-inner">
          <img src="<?php echo URLROOT; ?>/img/suwandel.png" alt="Suwandel" class="article-image">
          <div class="article-text-container">
            <h3>Suwandel (Traditional Variety)</h3>
            <p class="article-text">
              Suwandel is a premium traditional rice variety prized for aroma, soft texture, and taste. Mostly grown in wet zone areas, it has a maturation period of around 120 days. 
              <br><strong>Planting Tips:</strong> Best in fertile, clay-rich soils. Transplant seedlings 25 x 25 cm apart and maintain consistent water levels.
              <br><strong>Pest & Disease Management:</strong> Moderately susceptible to blast disease and leaf spot. Regular monitoring and timely organic fungicide application is recommended.
              <br><strong>Harvesting:</strong> Harvest when grains are fully mature to retain aroma and quality.
              <br><strong>Yield:</strong> Average: 3-4 tons per hectare. Premium quality fetches higher market price.
            </p>
            <button class="read-more-btn">Read More</button>
          </div>
        </div>
      </div>

      <!-- Article 3: Bg 300 -->
      <div class="article-box">
        <div class="article-inner">
          <img src="<?php echo URLROOT; ?>/img/bg300.jpeg" alt="Bg 300" class="article-image">
          <div class="article-text-container">
            <h3>Bg 300 (High Yield)</h3>
            <p class="article-text">
              Bg 300 is a high-yield commercial variety resistant to several pests and diseases. Growth period is around 110 days. Strong stalks prevent lodging under heavy rainfall. 
              <br><strong>Planting Tips:</strong> Well-fertilized fields with proper water retention. Transplant seedlings at 20 x 20 cm spacing. Regular weeding and nitrogen management boost yield.
              <br><strong>Pest Control:</strong> Resistant to brown planthopper and stem borers; monitor for occasional outbreaks.
              <br><strong>Harvesting:</strong> Harvest when 80-90% of grains ripen. Proper drying ensures grain quality for storage or sale.
              <br><strong>Yield:</strong> 6-7 tons per hectare under ideal conditions. Suitable for high-demand commercial production.
            </p>
            <button class="read-more-btn">Read More</button>
          </div>
        </div>
      </div>

    </div>

    <a href="<?php echo URLROOT; ?>/knowledgecenter/KnowledgecenterAdmin" class="back-btn">← Back to Knowledge Center</a>
  </div>
</main>

<?php require_once APPROOT . '/views/inc/footer.php'; ?>

<!-- Inline CSS for article layout -->
<style>
.article-box {
  max-width: 900px;
  margin: 0 auto 30px;
  padding: 15px;
  border: 1px solid #ddd;
  border-radius: 12px;
  box-shadow: 0 4px 12px rgba(0,0,0,0.08);
}

.article-inner {
  display: flex;
  gap: 20px;
  align-items: flex-start;
  flex-wrap: wrap;
}

.article-image {
  width: 200px;
  height: 150px;
  object-fit: cover;
  border-radius: 12px;
  flex-shrink: 0;
}

.article-text-container {
  flex: 1;
}

.article-text {
  display: -webkit-box;
  -webkit-line-clamp: 3;
  -webkit-box-orient: vertical;
  overflow: hidden;
  transition: all 0.3s ease;
}

.read-more-btn {
  display: inline-block;
  margin-top: 10px;
  background-color: #4caf50;
  color: white;
  border: none;
  padding: 8px 16px;
  border-radius: 8px;
  cursor: pointer;
  font-weight: 600;
  transition: all 0.3s ease;
}

.read-more-btn:hover {
  background-color: #388e3c;
  transform: scale(1.05);
}

.article-text.expanded {
  display: block;
  -webkit-line-clamp: none;
}

.article-heading {
  font-size: 40px;
  font-weight: bold;
  color: #2f9b63;
  text-align: center;
  margin-bottom: 20px;
}

.article-description {
  text-align: center;
  max-width: 800px;
  margin: 0 auto 30px;
  font-size: 18px;
  color: #555;
  line-height: 1.5;
}

.back-btn {
  display: inline-block;
  margin-top: 40px;
  background-color: #4caf50;
  color: white;
  padding: 10px 18px;
  border-radius: 8px;
  text-decoration: none;
  font-weight: 600;
  transition: all 0.3s ease;
}

.back-btn:hover {
  background-color: #388e3c;
  transform: scale(1.05);
}
</style>

<!-- JS for toggling Read More -->
<script>
document.addEventListener('DOMContentLoaded', function() {
  const buttons = document.querySelectorAll('.read-more-btn');

  buttons.forEach(button => {
    button.addEventListener('click', function() {
      const articleText = this.previousElementSibling;
      if(articleText.classList.contains('expanded')) {
        articleText.classList.remove('expanded');
        this.textContent = "Read More";
      } else {
        articleText.classList.add('expanded');
        this.textContent = "Show Less";
      }
    });
  });
});
</script>
