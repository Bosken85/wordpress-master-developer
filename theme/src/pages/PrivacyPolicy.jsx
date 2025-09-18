import { motion } from 'framer-motion'
import { Shield, Eye, Lock, Database, Mail, Phone } from 'lucide-react'
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card.jsx'

function PrivacyPolicy() {
  const lastUpdated = "September 18, 2025"

  const sections = [
    {
      icon: <Database className="w-6 h-6" />,
      title: "Information We Collect",
      content: [
        "Personal information you provide when contacting us (name, email, phone number)",
        "Project details and requirements shared during consultations",
        "Website usage data through analytics tools",
        "Communication records for project management purposes"
      ]
    },
    {
      icon: <Eye className="w-6 h-6" />,
      title: "How We Use Your Information",
      content: [
        "To provide WordPress development services and support",
        "To communicate about your projects and respond to inquiries",
        "To improve our services and website functionality",
        "To send project updates and relevant service information"
      ]
    },
    {
      icon: <Lock className="w-6 h-6" />,
      title: "Information Protection",
      content: [
        "We implement industry-standard security measures",
        "Your data is stored on secure, encrypted servers",
        "Access to personal information is limited to authorized personnel",
        "We regularly update our security protocols and systems"
      ]
    },
    {
      icon: <Shield className="w-6 h-6" />,
      title: "Your Rights",
      content: [
        "Request access to your personal information",
        "Request correction of inaccurate data",
        "Request deletion of your personal information",
        "Opt-out of marketing communications at any time"
      ]
    }
  ]

  return (
    <div className="min-h-screen bg-background">
      {/* Hero Section */}
      <section className="py-20 bg-muted/30">
        <div className="container mx-auto px-4">
          <motion.div
            initial={{ opacity: 0, y: 30 }}
            animate={{ opacity: 1, y: 0 }}
            transition={{ duration: 0.8 }}
            className="text-center mb-16"
          >
            <h1 className="text-5xl md:text-6xl font-bold mb-6">Privacy Policy</h1>
            <p className="text-xl text-muted-foreground max-w-4xl mx-auto">
              Your privacy is important to us. This policy explains how we collect, use, and protect your personal information.
            </p>
            <p className="text-sm text-muted-foreground mt-4">
              Last updated: {lastUpdated}
            </p>
          </motion.div>
        </div>
      </section>

      {/* Introduction */}
      <section className="py-16">
        <div className="container mx-auto px-4 max-w-4xl">
          <motion.div
            initial={{ opacity: 0, y: 30 }}
            whileInView={{ opacity: 1, y: 0 }}
            transition={{ duration: 0.6 }}
            viewport={{ once: true }}
            className="prose prose-lg max-w-none"
          >
            <p className="text-lg leading-relaxed mb-8">
              WordPress Master Developer ("we," "our," or "us") is committed to protecting your privacy and ensuring the security of your personal information. This Privacy Policy explains how we collect, use, disclose, and safeguard your information when you visit our website or use our WordPress development services.
            </p>
            <p className="text-lg leading-relaxed mb-8">
              By accessing our website or engaging our services, you agree to the collection and use of information in accordance with this policy. If you do not agree with our policies and practices, please do not use our services.
            </p>
          </motion.div>
        </div>
      </section>

      {/* Main Sections */}
      <section className="py-16 bg-muted/30">
        <div className="container mx-auto px-4">
          <div className="grid md:grid-cols-2 gap-8 max-w-6xl mx-auto">
            {sections.map((section, index) => (
              <motion.div
                key={index}
                initial={{ opacity: 0, y: 30 }}
                whileInView={{ opacity: 1, y: 0 }}
                transition={{ duration: 0.6, delay: index * 0.1 }}
                viewport={{ once: true }}
              >
                <Card className="h-full">
                  <CardHeader>
                    <div className="w-12 h-12 bg-orange-500/10 rounded-lg flex items-center justify-center mb-4 text-orange-500">
                      {section.icon}
                    </div>
                    <CardTitle className="text-xl">{section.title}</CardTitle>
                  </CardHeader>
                  <CardContent>
                    <ul className="space-y-3">
                      {section.content.map((item, itemIndex) => (
                        <li key={itemIndex} className="flex items-start space-x-3">
                          <div className="w-2 h-2 bg-orange-500 rounded-full mt-2 flex-shrink-0"></div>
                          <span className="text-muted-foreground">{item}</span>
                        </li>
                      ))}
                    </ul>
                  </CardContent>
                </Card>
              </motion.div>
            ))}
          </div>
        </div>
      </section>

      {/* Detailed Sections */}
      <section className="py-16">
        <div className="container mx-auto px-4 max-w-4xl">
          <div className="space-y-12">
            {/* Cookies and Tracking */}
            <motion.div
              initial={{ opacity: 0, y: 30 }}
              whileInView={{ opacity: 1, y: 0 }}
              transition={{ duration: 0.6 }}
              viewport={{ once: true }}
            >
              <h2 className="text-3xl font-bold mb-6">Cookies and Tracking Technologies</h2>
              <div className="prose prose-lg max-w-none">
                <p className="mb-4">
                  We use cookies and similar tracking technologies to enhance your browsing experience and analyze website traffic. Cookies are small data files stored on your device that help us:
                </p>
                <ul className="list-disc pl-6 space-y-2 mb-6">
                  <li>Remember your preferences and settings</li>
                  <li>Analyze website performance and user behavior</li>
                  <li>Provide personalized content and recommendations</li>
                  <li>Ensure website security and prevent fraud</li>
                </ul>
                <p>
                  You can control cookie settings through your browser preferences. However, disabling certain cookies may affect website functionality.
                </p>
              </div>
            </motion.div>

            {/* Data Sharing */}
            <motion.div
              initial={{ opacity: 0, y: 30 }}
              whileInView={{ opacity: 1, y: 0 }}
              transition={{ duration: 0.6 }}
              viewport={{ once: true }}
            >
              <h2 className="text-3xl font-bold mb-6">Information Sharing and Disclosure</h2>
              <div className="prose prose-lg max-w-none">
                <p className="mb-4">
                  We do not sell, trade, or otherwise transfer your personal information to third parties without your consent, except in the following circumstances:
                </p>
                <ul className="list-disc pl-6 space-y-2 mb-6">
                  <li><strong>Service Providers:</strong> We may share information with trusted third-party service providers who assist in website operation and service delivery</li>
                  <li><strong>Legal Requirements:</strong> We may disclose information when required by law or to protect our rights and safety</li>
                  <li><strong>Business Transfers:</strong> Information may be transferred in connection with a merger, acquisition, or sale of business assets</li>
                  <li><strong>Consent:</strong> We may share information with your explicit consent for specific purposes</li>
                </ul>
              </div>
            </motion.div>

            {/* Data Retention */}
            <motion.div
              initial={{ opacity: 0, y: 30 }}
              whileInView={{ opacity: 1, y: 0 }}
              transition={{ duration: 0.6 }}
              viewport={{ once: true }}
            >
              <h2 className="text-3xl font-bold mb-6">Data Retention</h2>
              <div className="prose prose-lg max-w-none">
                <p className="mb-4">
                  We retain your personal information only for as long as necessary to fulfill the purposes outlined in this Privacy Policy, unless a longer retention period is required or permitted by law. Factors determining retention periods include:
                </p>
                <ul className="list-disc pl-6 space-y-2 mb-6">
                  <li>The nature and sensitivity of the information</li>
                  <li>Legal and regulatory requirements</li>
                  <li>Business and operational needs</li>
                  <li>Your preferences and consent</li>
                </ul>
              </div>
            </motion.div>

            {/* International Transfers */}
            <motion.div
              initial={{ opacity: 0, y: 30 }}
              whileInView={{ opacity: 1, y: 0 }}
              transition={{ duration: 0.6 }}
              viewport={{ once: true }}
            >
              <h2 className="text-3xl font-bold mb-6">International Data Transfers</h2>
              <div className="prose prose-lg max-w-none">
                <p className="mb-4">
                  As we provide WordPress development services globally, your information may be transferred to and processed in countries other than your own. We ensure that such transfers comply with applicable data protection laws and implement appropriate safeguards to protect your information.
                </p>
              </div>
            </motion.div>

            {/* Children's Privacy */}
            <motion.div
              initial={{ opacity: 0, y: 30 }}
              whileInView={{ opacity: 1, y: 0 }}
              transition={{ duration: 0.6 }}
              viewport={{ once: true }}
            >
              <h2 className="text-3xl font-bold mb-6">Children's Privacy</h2>
              <div className="prose prose-lg max-w-none">
                <p className="mb-4">
                  Our services are not intended for individuals under the age of 18. We do not knowingly collect personal information from children under 18. If we become aware that we have collected personal information from a child under 18, we will take steps to delete such information promptly.
                </p>
              </div>
            </motion.div>

            {/* Updates to Policy */}
            <motion.div
              initial={{ opacity: 0, y: 30 }}
              whileInView={{ opacity: 1, y: 0 }}
              transition={{ duration: 0.6 }}
              viewport={{ once: true }}
            >
              <h2 className="text-3xl font-bold mb-6">Changes to This Privacy Policy</h2>
              <div className="prose prose-lg max-w-none">
                <p className="mb-4">
                  We may update this Privacy Policy from time to time to reflect changes in our practices or applicable laws. We will notify you of any material changes by posting the updated policy on our website and updating the "Last updated" date. Your continued use of our services after such changes constitutes acceptance of the updated policy.
                </p>
              </div>
            </motion.div>
          </div>
        </div>
      </section>

      {/* Contact Section */}
      <section className="py-16 bg-muted/30">
        <div className="container mx-auto px-4">
          <motion.div
            initial={{ opacity: 0, y: 30 }}
            whileInView={{ opacity: 1, y: 0 }}
            transition={{ duration: 0.6 }}
            viewport={{ once: true }}
            className="text-center max-w-3xl mx-auto"
          >
            <h2 className="text-3xl font-bold mb-6">Questions About This Policy?</h2>
            <p className="text-lg text-muted-foreground mb-8">
              If you have any questions about this Privacy Policy or our data practices, please contact us using the information below.
            </p>
            <div className="grid md:grid-cols-2 gap-6">
              <div className="flex items-center justify-center space-x-3">
                <Mail className="w-5 h-5 text-orange-500" />
                <span>contact@wpmaster.dev</span>
              </div>
              <div className="flex items-center justify-center space-x-3">
                <Phone className="w-5 h-5 text-orange-500" />
                <span>+1 (555) 123-4567</span>
              </div>
            </div>
          </motion.div>
        </div>
      </section>
    </div>
  )
}

export default PrivacyPolicy
