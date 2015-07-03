<!-- BEGIN: MAIN -->

<?xml version="1.0" encoding="utf-8"?>
<source creation-time="{PHP.sys.now|cot_date('Y-m-d H:i:s', $this)} GMT {PHP.cfg.defaulttimezone|cot_timezone_offset($this)}" host="{PHP.cfg.mainurl}">
  <vacancies>
	<!-- BEGIN: XML_ROW -->
    <vacancy>
      <url>{PHP.cfg.mainurl}/{XML_ROW_URL}</url>
      <creation-date>{XML_ROW_DATE_STAMP|cot_date('Y-m-d H:i:s', $this)} GMT {PHP.cfg.defaulttimezone|cot_timezone_offset($this)}</creation-date>
      <update-date>{XML_ROW_UPDATED_STAMP|cot_date('Y-m-d H:i:s', $this)} GMT {PHP.cfg.defaulttimezone|cot_timezone_offset($this)}</update-date>
      <salary>{XML_ROW_SALARY}</salary>
      <currency>руб</currency>
    <category>
      <industry>{XML_ROW_CATTITLE}</industry>
          <specialization></specialization>
    </category>
      <job-name>{XML_ROW_SHORTTITLE}</job-name>
      <employment></employment>
    <schedule></schedule>
      <description>{XML_ROW_DESC}</description>
      <duty>{XML_ROW_DUTY}</duty>
      <term>
          <contract></contract>
          <text>{XML_ROW_TERM}</text>
      </term>
      <requirement>
        <age>{XML_ROW_AGE}</age>
        <sex>{XML_ROW_SEX}</sex>
        <education>{XML_ROW_EDU}</education>
        <experience>{XML_ROW_EXP}</experience>
        <qualification>{XML_ROW_QUA}</qualification>
      </requirement>

      <addresses>
        <address>
          <location>{XML_ROW_ADDR}</location>
        </address>
      </addresses>

      <company>
        <name></name>
        <description></description>
        <logo></logo>
        <site>{XML_ROW_SITE}</site>
        <email>{XML_ROW_EMAIL}</email>
        <phone>{XML_ROW_PHONE}</phone>
        <fax></fax>
        <contact-name></contact-name>
        <hr-agency>false</hr-agency>
      </company>
    </vacancy>
	<!-- END: XML_ROW -->
  </vacancies>
</source>

<!-- END: MAIN -->