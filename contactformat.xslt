<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

<xsl:template match="/">
  <html>
  <body>
  <h2>Contact Table</h2>
    <table border="1">
      <tr bgcolor="#9acd32">
        <th style="text-align:left">Type</th>
        <th style="text-align:left">Address</th>
      </tr>
      <xsl:for-each select="contact/box">
      <tr>
        <td><xsl:value-of select="type"/></td>
        <td><xsl:value-of select="address"/></td>
      </tr>
      </xsl:for-each>
    </table>
  </body>
  </html>
</xsl:template>
</xsl:stylesheet>