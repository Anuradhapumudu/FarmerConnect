<?php require_once APPROOT . '/views/inc/officerheader.php'; ?>


<main class="main-content" id="mainContent">
  <div class="container">
    <h2 class="article-heading">Fertilizer Management</h2>
    <p class="article-description">
      Learn the best practices for using fertilizers efficiently to improve soil health and crop yield while reducing costs.
    </p>

    <div class="article-content">

      <!-- Article 1: Organic Fertilizers -->
      <div class="article-box">
        <div class="article-inner">
          <img src="<?php echo URLROOT; ?>/img/organic_fertilizer.jpg" alt="Organic Fertilizers" class="article-image">
          <div class="article-text-container">
            <h3>Organic Fertilizers</h3>
            <p class="article-text">
              Organic fertilizers such as compost, manure, and green manure enrich the soil with nutrients naturally. They improve soil structure, increase water retention, and support beneficial microorganisms.
              <br><strong>Application Tips:</strong> Apply during land preparation or as top dressing. Balance with crop nutrient requirements for optimal results.
              <br><strong>Benefits:</strong> Enhances long-term soil fertility and reduces dependency on chemical inputs.
              <br><strong>Precautions:</strong> Avoid over-application to prevent nutrient runoff.
            </p>
            <button class="read-more-btn">Read More</button>
          </div>
        </div>
      </div>

      <!-- Article 2: Chemical Fertilizers -->
      <div class="article-box">
        <div class="article-inner">
          <img src="<?php echo URLROOT; ?>/img/chemical_fertilizer.webp" alt="Chemical Fertilizers" class="article-image">
          <div class="article-text-container">
            <h3>Chemical Fertilizers</h3>
            <p class="article-text">
              Chemical fertilizers provide specific nutrients such as nitrogen, phosphorus, and potassium. They are fast-acting and help crops achieve rapid growth and higher yields.
              <br><strong>Application Tips:</strong> Follow recommended dosages according to soil tests. Split application during crop growth stages improves efficiency.
              <br><strong>Benefits:</strong> Quickly corrects nutrient deficiencies and boosts productivity.
              <br><strong>Precautions:</strong> Overuse can harm soil health and the environment. Use in combination with organic methods for sustainability.
            </p>
            <button class="read-more-btn">Read More</button>
          </div>
        </div>
      </div>

      <!-- Article 3: Foliar Fertilizers -->
      <div class="article-box">
        <div class="article-inner">
          <img src="<?php echo URLROOT; ?>/img/foliar_fertilizer.png" alt="Foliar Fertilizers" class="article-image">
          <div class="article-text-container">
            <h3>Foliar Fertilizers</h3>
            <p class="article-text">
              Foliar fertilizers are applied directly to the leaves and are absorbed quickly. They are ideal for correcting micronutrient deficiencies during critical growth stages.
              <br><strong>Application Tips:</strong> Apply in the early morning or late afternoon to prevent leaf burn. Ensure proper dilution as per product instructions.
              <br><strong>Benefits:</strong> Rapid nutrient absorption, improves crop quality, and supports recovery from stress.
              <br><strong>Precautions:</strong> Avoid application during high sunlight or drought stress to prevent leaf damage.
            </p>
            <button class="read-more-btn">Read More</button>
          </div>
        </div>
      </div>

    </div>

    <a href="<?php echo URLROOT; ?>/knowledgecenter/KnowledgecenterOfficer" class="back-btn">← Back to Knowledge Center</a>
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
